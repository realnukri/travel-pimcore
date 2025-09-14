<?php

namespace App\Command;

use Pimcore\Console\AbstractCommand;
use Pimcore\Model\DataObject\Hotel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportHotelsCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('app:import-hotels')
            ->setDescription('Import hotels from travel project into Pimcore data objects');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Hotel data array (converted from TypeScript)
        $hotels = [
            [
                'id' => 'grand-palace-paris',
                'name' => 'Grand Palace Hotel Paris',
                'location' => 'Paris, Frankreich',
                'country' => 'Frankreich',
                'description' => 'Luxuriöses 5-Sterne-Hotel im Herzen von Paris mit Blick auf den Eiffelturm. Erleben Sie französische Eleganz und erstklassigen Service.',
                'rating' => 4.9,
                'reviewCount' => 2341,
                'pricePerNight' => 450,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Fitness', 'Concierge', 'Parking'],
                'featured' => true
            ],
            [
                'id' => 'alpine-resort-swiss',
                'name' => 'Alpine Resort Zermatt',
                'location' => 'Zermatt, Schweiz',
                'country' => 'Schweiz',
                'description' => 'Gemütliches Bergresort mit atemberaubendem Matterhorn-Blick. Perfekt für Ski-Enthusiasten und Naturliebhaber.',
                'rating' => 4.8,
                'reviewCount' => 1876,
                'pricePerNight' => 380,
                'amenities' => ['WiFi', 'Spa', 'Restaurant', 'Bar', 'Ski Storage', 'Sauna', 'Parking', 'Shuttle'],
                'featured' => true
            ],
            [
                'id' => 'beach-paradise-maldives',
                'name' => 'Beach Paradise Maldives',
                'location' => 'Malé, Malediven',
                'country' => 'Malediven',
                'description' => 'Exklusives Inselresort mit privaten Wasservillen und kristallklarem Wasser. Der perfekte Ort für Ihren Traumurlaub.',
                'rating' => 5.0,
                'reviewCount' => 987,
                'pricePerNight' => 850,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Water Sports', 'Diving Center', 'Private Beach'],
                'featured' => true
            ],
            [
                'id' => 'roma-boutique',
                'name' => 'Roma Boutique Hotel',
                'location' => 'Rom, Italien',
                'country' => 'Italien',
                'description' => 'Charmantes Boutique-Hotel nahe dem Kolosseum. Italienisches Design trifft auf modernen Komfort.',
                'rating' => 4.7,
                'reviewCount' => 1543,
                'pricePerNight' => 220,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Room Service', 'Concierge', 'Air Conditioning'],
                'featured' => false
            ],
            [
                'id' => 'tokyo-tower-hotel',
                'name' => 'Tokyo Tower Hotel',
                'location' => 'Tokio, Japan',
                'country' => 'Japan',
                'description' => 'Modernes Stadthotel mit spektakulärem Blick auf Tokyo Tower. Erleben Sie japanische Gastfreundschaft auf höchstem Niveau.',
                'rating' => 4.8,
                'reviewCount' => 2109,
                'pricePerNight' => 340,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Spa', 'Fitness', 'Business Center', 'Parking'],
                'featured' => true
            ],
            [
                'id' => 'london-royal',
                'name' => 'The Royal London',
                'location' => 'London, UK',
                'country' => 'Vereinigtes Königreich',
                'description' => 'Historisches Hotel im viktorianischen Stil nahe Westminster Abbey. Britische Tradition trifft auf modernen Luxus.',
                'rating' => 4.6,
                'reviewCount' => 1789,
                'pricePerNight' => 290,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Tea Room', 'Concierge', 'Fitness', 'Parking'],
                'featured' => false
            ],
            [
                'id' => 'dubai-palm-resort',
                'name' => 'Palm Resort Dubai',
                'location' => 'Dubai, VAE',
                'country' => 'Vereinigte Arabische Emirate',
                'description' => 'Luxusresort auf der Palm Jumeirah mit privatem Strand und Unterwasserzimmern.',
                'rating' => 4.9,
                'reviewCount' => 2456,
                'pricePerNight' => 680,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Private Beach', 'Water Park', 'Kids Club'],
                'featured' => true
            ],
            [
                'id' => 'santorini-cave',
                'name' => 'Santorini Cave Suites',
                'location' => 'Santorini, Griechenland',
                'country' => 'Griechenland',
                'description' => 'Traditionelle Höhlensuiten mit atemberaubendem Caldera-Blick. Romantik pur in der Ägäis.',
                'rating' => 4.9,
                'reviewCount' => 1234,
                'pricePerNight' => 420,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Terrace', 'Room Service'],
                'featured' => false
            ],
            [
                'id' => 'new-york-central',
                'name' => 'Central Park Plaza',
                'location' => 'New York, USA',
                'country' => 'USA',
                'description' => 'Ikonisches Hotel am Central Park mit Blick auf die Manhattan Skyline.',
                'rating' => 4.7,
                'reviewCount' => 3421,
                'pricePerNight' => 520,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Spa', 'Fitness', 'Business Center', 'Concierge', 'Parking'],
                'featured' => false
            ],
            [
                'id' => 'bali-jungle',
                'name' => 'Bali Jungle Retreat',
                'location' => 'Ubud, Bali',
                'country' => 'Indonesien',
                'description' => 'Öko-Resort im balinesischen Dschungel mit Yoga-Retreat und Wellness-Programmen.',
                'rating' => 4.8,
                'reviewCount' => 876,
                'pricePerNight' => 180,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Yoga Studio', 'Meditation Garden', 'Shuttle'],
                'featured' => false
            ],
            [
                'id' => 'barcelona-modernist',
                'name' => 'Hotel Modernista Barcelona',
                'location' => 'Barcelona, Spanien',
                'country' => 'Spanien',
                'description' => 'Art Nouveau Hotel im Herzen des Eixample-Viertels, nahe der Sagrada Familia.',
                'rating' => 4.6,
                'reviewCount' => 1567,
                'pricePerNight' => 195,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Rooftop Terrace', 'Concierge', 'Air Conditioning'],
                'featured' => false
            ],
            [
                'id' => 'vienna-imperial',
                'name' => 'Hotel Imperial Vienna',
                'location' => 'Wien, Österreich',
                'country' => 'Österreich',
                'description' => 'Prachtvolles Hotel an der Ringstraße mit kaiserlichem Flair und Tradition seit 1873.',
                'rating' => 4.8,
                'reviewCount' => 1923,
                'pricePerNight' => 340,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Spa', 'Fitness', 'Butler Service', 'Parking'],
                'featured' => false
            ],
            [
                'id' => 'amsterdam-canal',
                'name' => 'Canal House Amsterdam',
                'location' => 'Amsterdam, Niederlande',
                'country' => 'Niederlande',
                'description' => 'Historisches Grachtenhaus aus dem 17. Jahrhundert, liebevoll restauriert.',
                'rating' => 4.5,
                'reviewCount' => 1098,
                'pricePerNight' => 245,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Library', 'Garden', 'Bike Rental'],
                'featured' => false
            ],
            [
                'id' => 'singapore-marina',
                'name' => 'Marina Bay Suites',
                'location' => 'Singapur',
                'country' => 'Singapur',
                'description' => 'Futuristisches Hotel mit Infinity Pool auf dem Dach und Blick über die Stadt.',
                'rating' => 4.9,
                'reviewCount' => 2876,
                'pricePerNight' => 480,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Casino', 'Shopping Mall', 'Parking'],
                'featured' => true
            ],
            [
                'id' => 'prague-golden',
                'name' => 'Golden Prague Hotel',
                'location' => 'Prag, Tschechien',
                'country' => 'Tschechien',
                'description' => 'Barockes Juwel in der Altstadt mit Blick auf die Karlsbrücke.',
                'rating' => 4.6,
                'reviewCount' => 1432,
                'pricePerNight' => 165,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Spa', 'Concierge', 'Airport Shuttle'],
                'featured' => false
            ],
            [
                'id' => 'istanbul-bosphorus',
                'name' => 'Bosphorus Palace Istanbul',
                'location' => 'Istanbul, Türkei',
                'country' => 'Türkei',
                'description' => 'Osmanischer Palast am Bosporus mit traumhaftem Blick auf zwei Kontinente.',
                'rating' => 4.7,
                'reviewCount' => 1789,
                'pricePerNight' => 275,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Hammam', 'Private Boat', 'Parking'],
                'featured' => false
            ],
            [
                'id' => 'sydney-harbour',
                'name' => 'Sydney Harbour Hotel',
                'location' => 'Sydney, Australien',
                'country' => 'Australien',
                'description' => 'Modernes Hotel mit spektakulärem Blick auf Opera House und Harbour Bridge.',
                'rating' => 4.8,
                'reviewCount' => 2234,
                'pricePerNight' => 385,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Fitness', 'Business Center'],
                'featured' => false
            ],
            [
                'id' => 'lisbon-tiles',
                'name' => 'Azulejo Palace Lisbon',
                'location' => 'Lissabon, Portugal',
                'country' => 'Portugal',
                'description' => 'Boutique-Hotel in einem restaurierten Palast mit traditionellen Azulejo-Fliesen.',
                'rating' => 4.5,
                'reviewCount' => 987,
                'pricePerNight' => 185,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Rooftop', 'Library', 'Wine Cellar'],
                'featured' => false
            ],
            [
                'id' => 'copenhagen-design',
                'name' => 'Design Hotel Copenhagen',
                'location' => 'Kopenhagen, Dänemark',
                'country' => 'Dänemark',
                'description' => 'Skandinavisches Design trifft auf Hygge-Atmosphäre im Herzen der Stadt.',
                'rating' => 4.6,
                'reviewCount' => 1123,
                'pricePerNight' => 295,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Spa', 'Fitness', 'Bike Rental', 'Parking'],
                'featured' => false
            ],
            [
                'id' => 'marrakech-riad',
                'name' => 'Riad Royal Marrakech',
                'location' => 'Marrakesch, Marokko',
                'country' => 'Marokko',
                'description' => 'Authentisches Riad in der Medina mit traditionellem Hammam und Dachterrasse.',
                'rating' => 4.7,
                'reviewCount' => 1345,
                'pricePerNight' => 155,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Hammam', 'Rooftop', 'Airport Transfer'],
                'featured' => false
            ]
        ];

        $output->writeln('<info>Starting hotel import...</info>');
        $output->writeln('Total hotels to import: ' . count($hotels));
        $output->writeln('');

        $successCount = 0;
        $errorCount = 0;

        // Get or create the parent folder for hotels
        $parentFolder = \Pimcore\Model\DataObject\Service::createFolderByPath('/Hotels');

        foreach ($hotels as $hotelData) {
            try {
                // Check if hotel already exists
                $existingHotel = Hotel::getByPath('/Hotels/' . $hotelData['id']);

                if ($existingHotel) {
                    $output->writeln('<comment>Hotel already exists: ' . $hotelData['name'] . ' - Updating...</comment>');
                    $hotel = $existingHotel;
                } else {
                    // Create new hotel object
                    $hotel = new Hotel();
                    $hotel->setKey($hotelData['id']);
                    $hotel->setParent($parentFolder);
                    $output->writeln('Creating new hotel: ' . $hotelData['name']);
                }

                // Set hotel properties
                $hotel->setLocation($hotelData['location']);
                $hotel->setRating($hotelData['rating']);
                $hotel->setReviewCount($hotelData['reviewCount']);
                $hotel->setPrice($hotelData['pricePerNight']);

                // Set featured checkbox
                $hotel->setFeatured($hotelData['featured']);

                // Set amenities (multiselect - expects array)
                $hotel->setAmenities($hotelData['amenities']);

                // Set localized fields (name and description) for all required locales
                $hotel->setName($hotelData['name'], 'de');
                $hotel->setDescription($hotelData['description'], 'de');

                $hotel->setName($hotelData['name'], 'en');
                $hotel->setDescription($hotelData['description'], 'en');

                $hotel->setName($hotelData['name'], 'fr');
                $hotel->setDescription($hotelData['description'], 'fr');

                // Publish the hotel
                $hotel->setPublished(true);

                // Save the hotel
                $hotel->save();

                $successCount++;
                $output->writeln('<info>✓ Successfully imported: ' . $hotelData['name'] . '</info>');

            } catch (\Exception $e) {
                $errorCount++;
                $output->writeln('<error>✗ Error importing ' . $hotelData['name'] . ': ' . $e->getMessage() . '</error>');
            }
        }

        $output->writeln('');
        $output->writeln('<info>=================================</info>');
        $output->writeln('<info>Import completed!</info>');
        $output->writeln('<info>Successfully imported: ' . $successCount . ' hotels</info>');
        $output->writeln('<info>Errors: ' . $errorCount . '</info>');
        $output->writeln('<info>=================================</info>');

        return self::SUCCESS;
    }
}