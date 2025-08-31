<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Hotel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class HotelController extends FrontendController
{
    /**
     * @Route("/hotels", name="hotel_listing")
     */
    public function listingAction(Request $request, PaginatorInterface $paginator): Response
    {
        // Lade alle veröffentlichten Hotels
        $hotelList = new Hotel\Listing();
        $hotelList->setCondition("published = 1");
        $hotelList->setOrderKey("featured");
        $hotelList->setOrder("DESC");

        // Pagination mit KnpPaginator
        $pagination = $paginator->paginate(
            $hotelList,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('hotels/listing.html.twig', [
            'hotels' => $pagination,
            'paginator' => $pagination
        ]);
    }

    /**
     * @Route("/hotel/{id}", name="hotel_detail", requirements={"id"="\d+"})
     */
    public function detailAction(Request $request, int $id): Response
    {
        $hotel = Hotels::getById($id);

        if (!$hotel || !$hotel->isPublished()) {
            throw $this->createNotFoundException('Hotel nicht gefunden');
        }

        // Lade ähnliche Hotels (gleiche Location oder ähnlicher Preis)
        $similarHotels = new Hotels\Listing();
        $similarHotels->setCondition(
            "published = 1 AND o_id != ? AND (location = ? OR (price BETWEEN ? AND ?))",
            [
                $hotel->getId(),
                $hotel->getLocation(),
                $hotel->getPrice() * 0.8,
                $hotel->getPrice() * 1.2
            ]
        );
        $similarHotels->setLimit(3);

        return $this->render('hotels/detail.html.twig', [
            'hotel' => $hotel,
            'similarHotels' => $similarHotels->load()
        ]);
    }

    /**
     * @Route("/hotels/search", name="hotel_search")
     */
    public function searchAction(Request $request, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->get('q', '');
        $location = $request->get('location', '');
        $minPrice = $request->get('min_price', 0);
        $maxPrice = $request->get('max_price', 9999);
        $amenities = $request->get('amenities', []);
        $rating = $request->get('rating', 0);

        $hotelList = new Hotels\Listing();

        // Basis-Bedingung: nur veröffentlichte Hotels
        $conditions = ["published = 1"];
        $params = [];

        // Suchbegriff
        if (!empty($searchTerm)) {
            $conditions[] = "(name LIKE ? OR description LIKE ?)";
            $params[] = '%' . $searchTerm . '%';
            $params[] = '%' . $searchTerm . '%';
        }

        // Location Filter
        if (!empty($location)) {
            $conditions[] = "location LIKE ?";
            $params[] = '%' . $location . '%';
        }

        // Preis Filter
        if ($minPrice > 0 || $maxPrice < 9999) {
            $conditions[] = "price BETWEEN ? AND ?";
            $params[] = $minPrice;
            $params[] = $maxPrice;
        }

        // Rating Filter
        if ($rating > 0) {
            $conditions[] = "rating >= ?";
            $params[] = $rating;
        }

        // Amenities Filter (wenn implementiert als Multiselect)
        if (!empty($amenities) && is_array($amenities)) {
            foreach ($amenities as $amenity) {
                $conditions[] = "amenities LIKE ?";
                $params[] = '%' . $amenity . '%';
            }
        }

        // Setze die kombinierten Bedingungen
        if (!empty($conditions)) {
            $hotelList->setCondition(implode(' AND ', $conditions), $params);
        }

        // Sortierung
        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'price_asc':
                $hotelList->setOrderKey('price');
                $hotelList->setOrder('ASC');
                break;
            case 'price_desc':
                $hotelList->setOrderKey('price');
                $hotelList->setOrder('DESC');
                break;
            case 'rating':
                $hotelList->setOrderKey('rating');
                $hotelList->setOrder('DESC');
                break;
            case 'name':
                $hotelList->setOrderKey('name');
                $hotelList->setOrder('ASC');
                break;
            default:
                $hotelList->setOrderKey(['featured', 'rating']);
                $hotelList->setOrder(['DESC', 'DESC']);
        }

        // Pagination mit KnpPaginator
        $pagination = $paginator->paginate(
            $hotelList,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('hotels/search.html.twig', [
            'hotels' => $pagination,
            'paginator' => $pagination,
            'searchTerm' => $searchTerm,
            'location' => $location,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'amenities' => $amenities,
            'rating' => $rating,
            'sortBy' => $sortBy
        ]);
    }

    /**
     * @Route("/hotels/featured", name="hotel_featured")
     */
    public function featuredAction(Request $request): Response
    {
        // Lade nur empfohlene Hotels
        $hotelList = new Hotels\Listing();
        $hotelList->setCondition("published = 1 AND featured = 1");
        $hotelList->setOrderKey("rating");
        $hotelList->setOrder("DESC");
        $hotelList->setLimit(6);

        return $this->render('hotels/featured.html.twig', [
            'hotels' => $hotelList->load()
        ]);
    }

    /**
     * @Route("/hotels/deals", name="hotel_deals")
     */
    public function dealsAction(Request $request): Response
    {
        // Lade Hotels mit Rabatten
        $hotelList = new Hotels\Listing();
        $hotelList->setCondition("published = 1 AND originalPrice > price AND originalPrice IS NOT NULL");

        // Berechne den Rabatt-Prozentsatz
        $hotels = [];
        foreach ($hotelList->load() as $hotel) {
            if ($hotel->getOriginalPrice() > 0) {
                $discount = round((($hotel->getOriginalPrice() - $hotel->getPrice()) / $hotel->getOriginalPrice()) * 100);
                $hotels[] = [
                    'hotel' => $hotel,
                    'discount' => $discount
                ];
            }
        }

        // Sortiere nach höchstem Rabatt
        usort($hotels, function($a, $b) {
            return $b['discount'] - $a['discount'];
        });

        return $this->render('hotels/deals.html.twig', [
            'hotels' => $hotels
        ]);
    }
}
