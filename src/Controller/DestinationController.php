<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\Destionation;

class DestinationController extends FrontendController
{
    /**
     * @Route("/destinations", name="destination_list")
     */
    public function listAction(Request $request): Response
    {
        $destinationList = new Destionation\Listing();
        $destinationList->setOrderKey('name');
        $destinationList->setOrder('ASC');
        $destinations = $destinationList->load();
        
        return $this->render('destination/list.html.twig', [
            'destinations' => $destinations
        ]);
    }
    
    /**
     * @Route("/destination/{key}", name="destination_detail")
     */
    public function detailAction(Request $request, string $key): Response
    {
        // Find destination by iterating through all destinations
        // This avoids SQL column issues
        $destinationList = new Destionation\Listing();
        $allDestinations = $destinationList->load();
        
        $destination = null;
        foreach ($allDestinations as $dest) {
            if ($dest->getKey() === $key && $dest->isPublished()) {
                $destination = $dest;
                break;
            }
        }
        
        if (!$destination) {
            throw $this->createNotFoundException('Destination not found');
        }
        
        // Default activities (these could be stored in the data object later)
        $activities = [
            [
                'title' => 'Sightseeing',
                'description' => 'Entdecken Sie die wichtigsten Sehenswürdigkeiten und Wahrzeichen.',
                'icon' => 'camera'
            ],
            [
                'title' => 'Lokale Küche',
                'description' => 'Probieren Sie traditionelle Gerichte und lokale Spezialitäten.',
                'icon' => 'utensils'
            ],
            [
                'title' => 'Shopping',
                'description' => 'Finden Sie einzigartige Souvenirs und lokale Produkte.',
                'icon' => 'shopping-bag'
            ],
            [
                'title' => 'Kulturelle Aktivitäten',
                'description' => 'Erleben Sie die lokale Kultur, Traditionen und Bräuche.',
                'icon' => 'theater'
            ]
        ];
        
        // Get related destinations (excluding current one)
        $relatedDestinations = [];
        $count = 0;
        
        // Shuffle array for random related destinations
        shuffle($allDestinations);
        
        foreach ($allDestinations as $dest) {
            if ($dest->getId() !== $destination->getId() && $dest->isPublished() && $count < 3) {
                $relatedDestinations[] = $dest;
                $count++;
            }
        }
        
        // Prepare image gallery (use main image multiple times if no gallery)
        $images = [];
        if ($destination->getImage()) {
            // Add main image 3 times for carousel effect (in real app, you'd have multiple images)
            $images[] = $destination->getImage();
            $images[] = $destination->getImage();
            $images[] = $destination->getImage();
        }
        
        // Get additional images if available (from images gallery field if exists)
        if (method_exists($destination, 'getImages') && $destination->getImages()) {
            $imageGallery = $destination->getImages();
            if (is_array($imageGallery) || $imageGallery instanceof \Traversable) {
                $images = []; // Reset and use gallery images
                foreach ($imageGallery as $img) {
                    if ($img && $img->getImage()) {
                        $images[] = $img->getImage();
                    }
                }
            }
        }
        
        // If still no images, try to get at least the main image
        if (empty($images) && $destination->getImage()) {
            $images[] = $destination->getImage();
        }
        
        return $this->render('destination/detail.html.twig', [
            'destination' => $destination,
            'activities' => $activities,
            'images' => $images,
            'relatedDestinations' => $relatedDestinations,
            'bestTime' => 'Ganzjährig', // These could be added to the data object
            'climate' => 'Variiert je nach Saison'
        ]);
    }
}