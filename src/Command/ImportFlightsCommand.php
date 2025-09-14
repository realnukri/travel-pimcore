<?php

namespace App\Command;

use Pimcore\Console\AbstractCommand;
use Pimcore\Model\DataObject;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-flights',
    description: 'Import flights from travel project into Pimcore data objects',
)]
class ImportFlightsCommand extends AbstractCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        // Sample flight data from the travel project
        $flights = $this->getFlightData();
        
        // Get the parent folder for flights
        $parentFolder = DataObject\Folder::getByPath('/Flights');
        if (!$parentFolder) {
            $parentFolder = new DataObject\Folder();
            $parentFolder->setKey('Flights');
            $parentFolder->setParentId(1);
            $parentFolder->save();
            $io->note('Created Flights folder');
        }
        
        $counter = 0;
        $io->progressStart(count($flights));
        
        foreach ($flights as $flightData) {
            try {
                // Create unique key for the flight
                $key = $this->generateFlightKey($flightData);
                
                // Check if flight already exists
                $existingFlight = DataObject\Flight::getByPath('/Flights/' . $key);
                
                if (!$existingFlight) {
                    $flight = new DataObject\Flight();
                    $flight->setKey($key);
                    $flight->setParentId($parentFolder->getId());
                    $flight->setPublished(true);
                    
                    // Set flight properties
                    $flight->setFrom($flightData['from']);
                    $flight->setTo($flightData['to']);
                    $flight->setDepartureTime($flightData['departureTime']);
                    $flight->setArrivalTime($flightData['arrivalTime']);
                    $flight->setDuration($flightData['duration']);
                    $flight->setPrice($flightData['price']);
                    $flight->setStops($flightData['stops']);
                    $flight->setBaggage($flightData['baggage']);
                    $flight->setRating($flightData['rating']);
                    $flight->setAmenities($flightData['amenities']);
                    
                    // Set localized fields for all required languages
                    $flight->setAirline($flightData['airline'], 'de');
                    $flight->setAircraft($flightData['aircraft'], 'de');
                    $flight->setAirline($flightData['airline'], 'en');
                    $flight->setAircraft($flightData['aircraft'], 'en');
                    $flight->setAirline($flightData['airline'], 'fr');
                    $flight->setAircraft($flightData['aircraft'], 'fr');
                    
                    $flight->save();
                    $counter++;
                }
                
                $io->progressAdvance();
                
            } catch (\Exception $e) {
                $io->error('Error importing flight: ' . $e->getMessage());
            }
        }
        
        $io->progressFinish();
        $io->success(sprintf('Successfully imported %d flights', $counter));
        
        return self::SUCCESS;
    }
    
    private function generateFlightKey(array $flightData): string
    {
        return strtolower(str_replace(' ', '-', 
            $flightData['airline'] . '-' . 
            $flightData['from'] . '-' . 
            $flightData['to'] . '-' . 
            str_replace(':', '', $flightData['departureTime'])
        ));
    }
    
    private function getFlightData(): array
    {
        // Sample flight data based on the travel project structure
        return [
            // Germany to France
            [
                'airline' => 'Lufthansa',
                'from' => 'Berlin',
                'to' => 'Paris',
                'departureTime' => '06:30',
                'arrivalTime' => '08:45',
                'duration' => '2h 15m',
                'price' => 189,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.2,
                'amenities' => ['Wifi', 'Snacks', 'Entertainment'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'Air France',
                'from' => 'Berlin',
                'to' => 'Paris',
                'departureTime' => '11:20',
                'arrivalTime' => '13:35',
                'duration' => '2h 15m',
                'price' => 175,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.0,
                'amenities' => ['Wifi', 'Mahlzeit', 'Entertainment'],
                'aircraft' => 'Airbus A319'
            ],
            [
                'airline' => 'EasyJet',
                'from' => 'Berlin',
                'to' => 'Paris',
                'departureTime' => '14:15',
                'arrivalTime' => '16:30',
                'duration' => '2h 15m',
                'price' => 89,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck',
                'rating' => 3.8,
                'amenities' => ['Snacks kaufbar'],
                'aircraft' => 'Boeing 737-800'
            ],
            
            // München to Paris
            [
                'airline' => 'Lufthansa',
                'from' => 'München',
                'to' => 'Paris',
                'departureTime' => '08:45',
                'arrivalTime' => '10:30',
                'duration' => '1h 45m',
                'price' => 165,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.2,
                'amenities' => ['Wifi', 'Snacks', 'Entertainment'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'Air France',
                'from' => 'München',
                'to' => 'Paris',
                'departureTime' => '17:30',
                'arrivalTime' => '19:15',
                'duration' => '1h 45m',
                'price' => 155,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.0,
                'amenities' => ['Wifi', 'Mahlzeit'],
                'aircraft' => 'Airbus A321'
            ],
            
            // Germany to UK
            [
                'airline' => 'British Airways',
                'from' => 'München',
                'to' => 'London',
                'departureTime' => '06:30',
                'arrivalTime' => '08:40',
                'duration' => '2h 10m',
                'price' => 225,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.3,
                'amenities' => ['Wifi', 'Snacks', 'Entertainment', 'Priority Boarding'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'Lufthansa',
                'from' => 'München',
                'to' => 'London',
                'departureTime' => '11:20',
                'arrivalTime' => '13:30',
                'duration' => '2h 10m',
                'price' => 198,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.1,
                'amenities' => ['Wifi', 'Mahlzeit'],
                'aircraft' => 'Boeing 737-800'
            ],
            [
                'airline' => 'EasyJet',
                'from' => 'München',
                'to' => 'London',
                'departureTime' => '20:45',
                'arrivalTime' => '22:55',
                'duration' => '2h 10m',
                'price' => 95,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck',
                'rating' => 3.7,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Airbus A319'
            ],
            
            // Berlin to London
            [
                'airline' => 'British Airways',
                'from' => 'Berlin',
                'to' => 'London',
                'departureTime' => '08:45',
                'arrivalTime' => '10:45',
                'duration' => '2h 0m',
                'price' => 195,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.3,
                'amenities' => ['Wifi', 'Snacks', 'Entertainment'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'Ryanair',
                'from' => 'Berlin',
                'to' => 'London',
                'departureTime' => '14:15',
                'arrivalTime' => '16:15',
                'duration' => '2h 0m',
                'price' => 75,
                'stops' => 'Direktflug',
                'baggage' => '1x kleines Handgepäck',
                'rating' => 3.5,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Boeing 737-800'
            ],
            
            // Germany to USA
            [
                'airline' => 'Lufthansa',
                'from' => 'Frankfurt',
                'to' => 'New York',
                'departureTime' => '10:30',
                'arrivalTime' => '13:35',
                'duration' => '8h 5m',
                'price' => 689,
                'stops' => 'Direktflug',
                'baggage' => '2x Handgepäck, 2x Aufgabegepäck (23kg)',
                'rating' => 4.5,
                'amenities' => ['Wifi', 'Mahlzeiten', 'Entertainment', 'Premium Sitze'],
                'aircraft' => 'Boeing 747-8'
            ],
            [
                'airline' => 'United Airlines',
                'from' => 'Frankfurt',
                'to' => 'New York',
                'departureTime' => '14:15',
                'arrivalTime' => '17:20',
                'duration' => '8h 5m',
                'price' => 756,
                'stops' => 'Direktflug',
                'baggage' => '2x Handgepäck, 2x Aufgabegepäck (23kg)',
                'rating' => 4.2,
                'amenities' => ['Wifi', 'Mahlzeiten', 'Entertainment', 'Lounge Zugang'],
                'aircraft' => 'Boeing 777'
            ],
            
            // Germany to Spain
            [
                'airline' => 'Vueling',
                'from' => 'Hamburg',
                'to' => 'Barcelona',
                'departureTime' => '06:30',
                'arrivalTime' => '09:20',
                'duration' => '2h 50m',
                'price' => 125,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck',
                'rating' => 3.7,
                'amenities' => ['Snacks kaufbar'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'Eurowings',
                'from' => 'Hamburg',
                'to' => 'Barcelona',
                'departureTime' => '11:20',
                'arrivalTime' => '14:10',
                'duration' => '2h 50m',
                'price' => 145,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (20kg)',
                'rating' => 3.9,
                'amenities' => ['Wifi', 'Snacks'],
                'aircraft' => 'Airbus A319'
            ],
            [
                'airline' => 'Ryanair',
                'from' => 'Hamburg',
                'to' => 'Barcelona',
                'departureTime' => '17:30',
                'arrivalTime' => '20:20',
                'duration' => '2h 50m',
                'price' => 85,
                'stops' => 'Direktflug',
                'baggage' => '1x kleines Handgepäck',
                'rating' => 3.5,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Boeing 737-800'
            ],
            
            // Berlin to Madrid
            [
                'airline' => 'Iberia',
                'from' => 'Berlin',
                'to' => 'Madrid',
                'departureTime' => '08:45',
                'arrivalTime' => '11:55',
                'duration' => '3h 10m',
                'price' => 165,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.0,
                'amenities' => ['Wifi', 'Snacks', 'Entertainment'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'EasyJet',
                'from' => 'Berlin',
                'to' => 'Madrid',
                'departureTime' => '14:15',
                'arrivalTime' => '17:25',
                'duration' => '3h 10m',
                'price' => 98,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck',
                'rating' => 3.7,
                'amenities' => ['Snacks kaufbar'],
                'aircraft' => 'Airbus A321'
            ],
            
            // Germany to Italy
            [
                'airline' => 'Alitalia',
                'from' => 'Köln',
                'to' => 'Rom',
                'departureTime' => '06:30',
                'arrivalTime' => '08:45',
                'duration' => '2h 15m',
                'price' => 189,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.0,
                'amenities' => ['Wifi', 'Snacks', 'Entertainment'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'Ryanair',
                'from' => 'Köln',
                'to' => 'Rom',
                'departureTime' => '20:45',
                'arrivalTime' => '23:00',
                'duration' => '2h 15m',
                'price' => 78,
                'stops' => 'Direktflug',
                'baggage' => '1x kleines Handgepäck',
                'rating' => 3.5,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Boeing 737-800'
            ],
            
            // München to Mailand
            [
                'airline' => 'Lufthansa',
                'from' => 'München',
                'to' => 'Mailand',
                'departureTime' => '08:45',
                'arrivalTime' => '10:10',
                'duration' => '1h 25m',
                'price' => 145,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.1,
                'amenities' => ['Wifi', 'Snacks'],
                'aircraft' => 'Airbus A319'
            ],
            [
                'airline' => 'EasyJet',
                'from' => 'München',
                'to' => 'Mailand',
                'departureTime' => '17:30',
                'arrivalTime' => '18:55',
                'duration' => '1h 25m',
                'price' => 75,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck',
                'rating' => 3.7,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Airbus A320'
            ],
            
            // Frankfurt to Venedig
            [
                'airline' => 'Lufthansa',
                'from' => 'Frankfurt',
                'to' => 'Venedig',
                'departureTime' => '11:20',
                'arrivalTime' => '12:50',
                'duration' => '1h 30m',
                'price' => 155,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.1,
                'amenities' => ['Wifi', 'Snacks'],
                'aircraft' => 'Airbus A319'
            ],
            [
                'airline' => 'Ryanair',
                'from' => 'Frankfurt',
                'to' => 'Venedig',
                'departureTime' => '20:45',
                'arrivalTime' => '22:15',
                'duration' => '1h 30m',
                'price' => 65,
                'stops' => 'Direktflug',
                'baggage' => '1x kleines Handgepäck',
                'rating' => 3.5,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Boeing 737-800'
            ],
            
            // Germany to Netherlands
            [
                'airline' => 'KLM',
                'from' => 'Düsseldorf',
                'to' => 'Amsterdam',
                'departureTime' => '08:45',
                'arrivalTime' => '09:45',
                'duration' => '1h 0m',
                'price' => 95,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.1,
                'amenities' => ['Snacks'],
                'aircraft' => 'Embraer 190'
            ],
            [
                'airline' => 'Eurowings',
                'from' => 'Düsseldorf',
                'to' => 'Amsterdam',
                'departureTime' => '17:30',
                'arrivalTime' => '18:30',
                'duration' => '1h 0m',
                'price' => 85,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck',
                'rating' => 3.8,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Airbus A319'
            ],
            
            // Germany to Austria
            [
                'airline' => 'Austrian Airlines',
                'from' => 'Stuttgart',
                'to' => 'Wien',
                'departureTime' => '06:30',
                'arrivalTime' => '08:00',
                'duration' => '1h 30m',
                'price' => 165,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.2,
                'amenities' => ['Wifi', 'Snacks'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'Eurowings',
                'from' => 'Stuttgart',
                'to' => 'Wien',
                'departureTime' => '14:15',
                'arrivalTime' => '15:45',
                'duration' => '1h 30m',
                'price' => 125,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck',
                'rating' => 3.7,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Airbus A319'
            ],
            
            // München to Wien
            [
                'airline' => 'Austrian Airlines',
                'from' => 'München',
                'to' => 'Wien',
                'departureTime' => '08:45',
                'arrivalTime' => '09:55',
                'duration' => '1h 10m',
                'price' => 135,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.2,
                'amenities' => ['Wifi', 'Snacks'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'Lufthansa',
                'from' => 'München',
                'to' => 'Wien',
                'departureTime' => '17:30',
                'arrivalTime' => '18:40',
                'duration' => '1h 10m',
                'price' => 145,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.1,
                'amenities' => ['Wifi', 'Snacks'],
                'aircraft' => 'Embraer 195'
            ],
            
            // Germany to Switzerland
            [
                'airline' => 'Swiss',
                'from' => 'Frankfurt',
                'to' => 'Zürich',
                'departureTime' => '06:30',
                'arrivalTime' => '07:35',
                'duration' => '1h 5m',
                'price' => 185,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.4,
                'amenities' => ['Wifi', 'Snacks', 'Schweizer Schokolade'],
                'aircraft' => 'Airbus A220'
            ],
            [
                'airline' => 'Lufthansa',
                'from' => 'Frankfurt',
                'to' => 'Zürich',
                'departureTime' => '11:20',
                'arrivalTime' => '12:25',
                'duration' => '1h 5m',
                'price' => 175,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.1,
                'amenities' => ['Wifi', 'Snacks'],
                'aircraft' => 'Airbus A320'
            ],
            
            // Berlin to Genf
            [
                'airline' => 'Swiss',
                'from' => 'Berlin',
                'to' => 'Genf',
                'departureTime' => '08:45',
                'arrivalTime' => '10:45',
                'duration' => '2h 0m',
                'price' => 195,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.4,
                'amenities' => ['Wifi', 'Snacks', 'Schweizer Schokolade'],
                'aircraft' => 'Airbus A320'
            ],
            [
                'airline' => 'EasyJet',
                'from' => 'Berlin',
                'to' => 'Genf',
                'departureTime' => '20:45',
                'arrivalTime' => '22:45',
                'duration' => '2h 0m',
                'price' => 105,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck',
                'rating' => 3.7,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Airbus A319'
            ],
            
            // Germany to Turkey
            [
                'airline' => 'Turkish Airlines',
                'from' => 'Frankfurt',
                'to' => 'Istanbul',
                'departureTime' => '06:30',
                'arrivalTime' => '11:45',
                'duration' => '3h 15m',
                'price' => 285,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (30kg)',
                'rating' => 4.3,
                'amenities' => ['Wifi', 'Mahlzeiten', 'Entertainment', 'Türkischer Tee'],
                'aircraft' => 'Airbus A321'
            ],
            [
                'airline' => 'Lufthansa',
                'from' => 'Frankfurt',
                'to' => 'Istanbul',
                'departureTime' => '11:20',
                'arrivalTime' => '16:35',
                'duration' => '3h 15m',
                'price' => 295,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.1,
                'amenities' => ['Wifi', 'Mahlzeiten', 'Entertainment'],
                'aircraft' => 'Boeing 737-900'
            ],
            [
                'airline' => 'Pegasus',
                'from' => 'Frankfurt',
                'to' => 'Istanbul',
                'departureTime' => '20:45',
                'arrivalTime' => '02:00',
                'duration' => '3h 15m',
                'price' => 165,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck',
                'rating' => 3.6,
                'amenities' => ['Basis-Service'],
                'aircraft' => 'Airbus A330'
            ],
            
            // München to Dubai
            [
                'airline' => 'Emirates',
                'from' => 'München',
                'to' => 'Dubai',
                'departureTime' => '10:30',
                'arrivalTime' => '19:35',
                'duration' => '6h 5m',
                'price' => 589,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 2x Aufgabegepäck (30kg)',
                'rating' => 4.7,
                'amenities' => ['Wifi', 'Mahlzeiten', 'Entertainment', 'Premium Lounge'],
                'aircraft' => 'Airbus A380'
            ],
            [
                'airline' => 'Lufthansa',
                'from' => 'München',
                'to' => 'Dubai',
                'departureTime' => '22:15',
                'arrivalTime' => '07:20',
                'duration' => '6h 5m',
                'price' => 435,
                'stops' => 'Direktflug',
                'baggage' => '1x Handgepäck, 1x Aufgabegepäck (23kg)',
                'rating' => 4.2,
                'amenities' => ['Wifi', 'Mahlzeiten', 'Entertainment'],
                'aircraft' => 'Airbus A350'
            ]
        ];
    }
}