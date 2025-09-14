<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Hotel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HotelsController extends FrontendController
{
    /**
     * Display all hotels
     */
    public function defaultAction(Request $request): Response
    {
        // Get all published hotels
        $hotelsList = new Hotel\Listing();
        $hotelsList->setCondition('published = 1');
        $hotels = $hotelsList->load();

        // Debug: Check if hotels are loaded
        if (empty($hotels)) {
            // If no published hotels, try to get all hotels for debugging
            $allHotelsList = new Hotel\Listing();
            $allHotels = $allHotelsList->load();

            // Log the issue for debugging
            error_log("No published hotels found. Total hotels in system: " . count($allHotels));
        }

        // Separate featured hotels
        $featuredHotels = [];
        $regularHotels = [];

        foreach ($hotels as $hotel) {
            if ($hotel && $hotel->getFeatured()) {
                $featuredHotels[] = $hotel;
            } else {
                $regularHotels[] = $hotel;
            }
        }

        return $this->render('hotels/default.html.twig', [
            'featuredHotels' => $featuredHotels,
            'regularHotels' => $regularHotels,
            'allHotels' => $hotels,
            'totalCount' => count($hotels)
        ]);
    }

    /**
     * Display hotel detail page
     */
    public function detailAction(Request $request): Response
    {
        $hotelId = $request->get('id');

        if (!$hotelId) {
            throw $this->createNotFoundException('Hotel ID is required');
        }

        // Get hotel by ID
        $hotel = Hotel::getById($hotelId);

        if (!$hotel || !$hotel->getPublished()) {
            throw $this->createNotFoundException('Hotel not found');
        }

        // Get similar hotels (same location)
        $similarHotels = new Hotel\Listing();
        $similarHotels->setCondition('published = 1 AND location = ? AND id != ?', [$hotel->getLocation(), $hotel->getId()]);
        $similarHotels->setLimit(4);

        return $this->render('hotels/detail.html.twig', [
            'hotel' => $hotel,
            'similarHotels' => $similarHotels->load()
        ]);
    }

    /**
     * Filter hotels by location, price, rating etc.
     */
    public function filterAction(Request $request): Response
    {
        $location = $request->get('location');
        $minPrice = $request->get('min_price', 0);
        $maxPrice = $request->get('max_price', 10000);
        $minRating = $request->get('min_rating', 0);
        $featured = $request->get('featured');

        $hotelsList = new Hotel\Listing();

        // Build conditions
        $conditions = ['published = 1'];
        $params = [];

        if ($location) {
            $conditions[] = 'location LIKE ?';
            $params[] = '%' . $location . '%';
        }

        if ($minPrice) {
            $conditions[] = 'price >= ?';
            $params[] = $minPrice;
        }

        if ($maxPrice) {
            $conditions[] = 'price <= ?';
            $params[] = $maxPrice;
        }

        if ($minRating) {
            $conditions[] = 'rating >= ?';
            $params[] = $minRating;
        }

        if ($featured !== null) {
            $conditions[] = 'featured = ?';
            $params[] = $featured ? 1 : 0;
        }

        $hotelsList->setCondition(implode(' AND ', $conditions), $params);
        $hotelsList->setOrderKey('rating');
        $hotelsList->setOrder('DESC');

        return $this->render('hotels/filtered.html.twig', [
            'hotels' => $hotelsList->load(),
            'filters' => [
                'location' => $location,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'minRating' => $minRating,
                'featured' => $featured
            ]
        ]);
    }
}