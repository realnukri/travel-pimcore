<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Flight;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlightsController extends FrontendController
{
    /**
     * @Route("/flights", name="flights")
     */
    public function indexAction(Request $request): Response
    {
        // Fetch all published flight objects from Pimcore
        $flightListing = new Flight\Listing();
        $flightListing->setCondition('published = 1');
        $flightListing->setOrderKey('price');
        $flightListing->setOrder('ASC');
        $flightListing->setLimit(20);

        $flights = $flightListing->load();

        // Group flights by destination for popular destinations
        $destinationGroups = [];
        foreach ($flights as $flight) {
            $destination = $flight->getTo();
            if (!isset($destinationGroups[$destination])) {
                $destinationGroups[$destination] = [
                    'city' => $destination,
                    'country' => $this->getCountryForCity($destination),
                    'lowestPrice' => $flight->getPrice(),
                    'cheapestFlightId' => $flight->getId(),
                    'flights' => []
                ];
            }
            
            // Update lowest price and cheapest flight ID if this flight is cheaper
            if ($flight->getPrice() < $destinationGroups[$destination]['lowestPrice']) {
                $destinationGroups[$destination]['lowestPrice'] = $flight->getPrice();
                $destinationGroups[$destination]['cheapestFlightId'] = $flight->getId();
            }
            
            $destinationGroups[$destination]['flights'][] = $flight;
        }

        // Sort by lowest price and take top 6 destinations
        uasort($destinationGroups, function($a, $b) {
            return $a['lowestPrice'] <=> $b['lowestPrice'];
        });
        
        $popularDestinations = array_slice($destinationGroups, 0, 6, true);

        // Features
        $features = [
            [
                'icon' => 'plane',
                'title' => 'Beste Preise',
                'description' => 'Vergleichen Sie Preise von über 500 Airlines weltweit'
            ],
            [
                'icon' => 'clock',
                'title' => 'Schnelle Buchung',
                'description' => 'Buchen Sie Ihren Flug in weniger als 2 Minuten'
            ],
            [
                'icon' => 'star',
                'title' => '24/7 Support',
                'description' => 'Unser Kundenservice ist rund um die Uhr für Sie da'
            ],
            [
                'icon' => 'trending-up',
                'title' => 'Flexible Optionen',
                'description' => 'Kostenlose Stornierung bis zu 24h vor Abflug'
            ]
        ];

        return $this->render('flights/index.html.twig', [
            'popularDestinations' => $popularDestinations,
            'features' => $features,
            'flights' => $flights
        ]);
    }

    /**
     * @Route("/flights/{id}", name="flight_detail", requirements={"id"="\d+"})
     */
    public function detailAction($id): Response
    {
        $flight = Flight::getById($id);
        
        if (!$flight || !$flight->isPublished()) {
            throw $this->createNotFoundException('Flight not found');
        }
        
        // Calculate total price with taxes
        $basePrice = $flight->getPrice();
        $taxes = round($basePrice * 0.15);
        $totalPrice = $basePrice + $taxes;
        
        // Get similar flights (same route)
        $similarFlightsListing = new Flight\Listing();
        $similarFlightsListing->setCondition(
            "`from` = ? AND `to` = ? AND published = 1 AND oo_id != ?", 
            [$flight->getFrom(), $flight->getTo(), $flight->getId()]
        );
        $similarFlightsListing->setLimit(3);
        $similarFlightsListing->setOrderKey('price');
        $similarFlightsListing->setOrder('ASC');
        $similarFlights = $similarFlightsListing->load();
        
        return $this->render('flights/detail.html.twig', [
            'flight' => $flight,
            'basePrice' => $basePrice,
            'taxes' => $taxes,
            'totalPrice' => $totalPrice,
            'similarFlights' => $similarFlights
        ]);
    }
    
    /**
     * @Route("/flights/search", name="flights_search")
     */
    public function searchAction(Request $request): Response
    {
        $departure = $request->get('departure');
        $arrival = $request->get('arrival');
        $departureDate = $request->get('departure_date');
        $returnDate = $request->get('return_date');
        $passengers = $request->get('passengers', 1);

        $flightListing = new Flight\Listing();
        $flightListing->setCondition('published = 1');

        // Filter by departure and arrival cities
        if ($departure && $arrival) {
            $flightListing->setCondition("`from` = ? AND `to` = ? AND published = 1", [$departure, $arrival]);
        } elseif ($departure) {
            $flightListing->setCondition("`from` = ? AND published = 1", [$departure]);
        } elseif ($arrival) {
            $flightListing->setCondition("`to` = ? AND published = 1", [$arrival]);
        }

        $flightListing->setOrderKey('price');
        $flightListing->setOrder('ASC');
        $searchResults = $flightListing->load();

        return $this->render('flights/search.html.twig', [
            'searchResults' => $searchResults,
            'searchParams' => [
                'departure' => $departure,
                'arrival' => $arrival,
                'departureDate' => $departureDate,
                'returnDate' => $returnDate,
                'passengers' => $passengers
            ]
        ]);
    }

    private function getCountryForCity($city): string
    {
        $cityCountryMap = [
            'Paris' => 'Frankreich',
            'Rom' => 'Italien',
            'Mailand' => 'Italien',
            'Venedig' => 'Italien',
            'Barcelona' => 'Spanien',
            'Madrid' => 'Spanien',
            'Amsterdam' => 'Niederlande',
            'Wien' => 'Österreich',
            'Prag' => 'Tschechien',
            'Berlin' => 'Deutschland',
            'München' => 'Deutschland',
            'Frankfurt' => 'Deutschland',
            'Hamburg' => 'Deutschland',
            'Köln' => 'Deutschland',
            'Stuttgart' => 'Deutschland',
            'Düsseldorf' => 'Deutschland',
            'Nürnberg' => 'Deutschland',
            'London' => 'Vereinigtes Königreich',
            'New York' => 'USA',
            'Dubai' => 'VAE',
            'Istanbul' => 'Türkei',
            'Antalya' => 'Türkei',
            'Athen' => 'Griechenland',
            'Santorini' => 'Griechenland',
            'Lissabon' => 'Portugal',
            'Porto' => 'Portugal',
            'Stockholm' => 'Schweden',
            'Oslo' => 'Norwegen',
            'Kopenhagen' => 'Dänemark',
            'Warschau' => 'Polen',
            'Krakau' => 'Polen',
            'Zürich' => 'Schweiz',
            'Genf' => 'Schweiz',
            'Bangkok' => 'Thailand',
            'Singapur' => 'Singapur',
            'Tokyo' => 'Japan',
            'Sydney' => 'Australien'
        ];

        return $cityCountryMap[$city] ?? 'International';
    }

    private function getCountryFlag($country): string
    {
        $flags = [
            'Frankreich' => '🇫🇷',
            'Italien' => '🇮🇹',
            'Spanien' => '🇪🇸',
            'Niederlande' => '🇳🇱',
            'Österreich' => '🇦🇹',
            'Tschechien' => '🇨🇿',
            'Deutschland' => '🇩🇪',
            'Vereinigtes Königreich' => '🇬🇧',
            'USA' => '🇺🇸',
            'VAE' => '🇦🇪',
            'Türkei' => '🇹🇷',
            'Griechenland' => '🇬🇷',
            'Portugal' => '🇵🇹',
            'Schweden' => '🇸🇪',
            'Norwegen' => '🇳🇴',
            'Dänemark' => '🇩🇰',
            'Polen' => '🇵🇱',
            'Schweiz' => '🇨🇭',
            'Thailand' => '🇹🇭',
            'Singapur' => '🇸🇬',
            'Japan' => '🇯🇵',
            'Australien' => '🇦🇺',
            'Kanada' => '🇨🇦',
            'China' => '🇨🇳'
        ];

        return $flags[$country] ?? '🏳️';
    }
}
