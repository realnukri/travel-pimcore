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
        $flightListing->setLimit(6);

        $flights = $flightListing->load();

        // Popular destinations - could be fetched from DataObjects or hardcoded
        $popularDestinations = [
            [
                'city' => 'Paris',
                'country' => 'Frankreich',
                'price' => 'ab €89',
                'image' => '🇫🇷',
                'departure' => 'Berlin',
                'arrival' => 'Paris',
                'airline' => 'Air France'
            ],
            [
                'city' => 'Rom',
                'country' => 'Italien',
                'price' => 'ab €79',
                'image' => '🇮🇹',
                'departure' => 'Berlin',
                'arrival' => 'Rom',
                'airline' => 'Alitalia'
            ],
            [
                'city' => 'Barcelona',
                'country' => 'Spanien',
                'price' => 'ab €65',
                'image' => '🇪🇸',
                'departure' => 'Berlin',
                'arrival' => 'Barcelona',
                'airline' => 'Vueling'
            ],
            [
                'city' => 'Amsterdam',
                'country' => 'Niederlande',
                'price' => 'ab €59',
                'image' => '🇳🇱',
                'departure' => 'Berlin',
                'arrival' => 'Amsterdam',
                'airline' => 'KLM'
            ],
            [
                'city' => 'Wien',
                'country' => 'Österreich',
                'price' => 'ab €69',
                'image' => '🇦🇹',
                'departure' => 'Berlin',
                'arrival' => 'Wien',
                'airline' => 'Austrian Airlines'
            ],
            [
                'city' => 'Prag',
                'country' => 'Tschechien',
                'price' => 'ab €55',
                'image' => '🇨🇿',
                'departure' => 'Berlin',
                'arrival' => 'Prag',
                'airline' => 'Czech Airlines'
            ]
        ];

        // If flights DataObjects exist, use them instead
        if (!empty($flights)) {
            $popularDestinations = [];
            foreach ($flights as $flight) {
                $popularDestinations[] = [
                    'city' => $flight->getArrivalCity() ?: 'Unknown',
                    'country' => $flight->getArrivalCountry() ?: 'Unknown',
                    'price' => 'ab €' . ($flight->getPrice() ?: '0'),
                    'image' => $this->getCountryFlag($flight->getArrivalCountry()),
                    'departure' => $flight->getDepartureCity() ?: 'Unknown',
                    'arrival' => $flight->getArrivalCity() ?: 'Unknown',
                    'airline' => $flight->getAirline() ?: 'Unknown Airline'
                ];
            }
        }

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
     * @Route("/flights/search", name="flights_search")
     */
    public function searchAction(Request $request): Response
    {
        $departure = $request->get('departure');
        $arrival = $request->get('arrival');
        $departureDate = $request->get('departure_date');
        $returnDate = $request->get('return_date');
        $passengers = $request->get('passengers', 1);

        $flightListing = new Flights\Listing();

        $conditions = ['published = 1'];

        if ($departure) {
            $conditions[] = "departureCity LIKE :departure";
            $flightListing->setConditionParam('departure', '%' . $departure . '%');
        }

        if ($arrival) {
            $conditions[] = "arrivalCity LIKE :arrival";
            $flightListing->setConditionParam('arrival', '%' . $arrival . '%');
        }

        if ($departureDate) {
            $conditions[] = "departureDate >= :departureDate";
            $flightListing->setConditionParam('departureDate', $departureDate);
        }

        $flightListing->setCondition(implode(' AND ', $conditions));
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
            'Kanada' => '🇨🇦',
            'Japan' => '🇯🇵',
            'China' => '🇨🇳'
        ];

        return $flags[$country] ?? '🏳️';
    }
}
