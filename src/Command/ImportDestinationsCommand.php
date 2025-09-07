<?php

namespace App\Command;

use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pimcore\Model\DataObject\Destionation;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject\Service;
use Pimcore\Model\DataObject\Folder;

class ImportDestinationsCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('app:import-destinations')
            ->setDescription('Import destinations from travel project');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Destination data
        $destinations = [
            [
                'id' => 'maldives',
                'name' => 'Malediven',
                'country' => 'Malediven',
                'description' => 'Ein tropisches Paradies mit kristallklarem Wasser, weißen Sandstränden und luxuriösen Überwasser-Villen. Perfekt für Flitterwochen und Taucher.',
                'image' => 'maldives-1.jpg',
                'rating' => 4.9,
                'reviewCount' => 3456,
                'startingPrice' => 2999,
                'popular' => true,
                'highlights' => ['Überwasser-Villen', 'Weltklasse-Tauchen', 'Private Inseln', 'Spa-Resorts']
            ],
            [
                'id' => 'swiss-alps',
                'name' => 'Schweizer Alpen',
                'country' => 'Schweiz',
                'description' => 'Majestätische Berggipfel, malerische Dörfer und erstklassige Skigebiete. Ein Paradies für Wintersportler und Naturliebhaber.',
                'image' => 'swiss-alps-1.jpg',
                'rating' => 4.8,
                'reviewCount' => 2890,
                'startingPrice' => 1499,
                'popular' => true,
                'highlights' => ['Skifahren', 'Bergbahnen', 'Alpendörfer', 'Schweizer Schokolade']
            ],
            [
                'id' => 'prague',
                'name' => 'Prag',
                'country' => 'Tschechien',
                'description' => 'Die goldene Stadt mit ihrer beeindruckenden Architektur, historischen Brücken und lebendigen Kulturszene.',
                'image' => 'prague-1.jpg',
                'rating' => 4.7,
                'reviewCount' => 4123,
                'startingPrice' => 599,
                'popular' => true,
                'highlights' => ['Prager Burg', 'Karlsbrücke', 'Altstadt', 'Tschechisches Bier']
            ],
            [
                'id' => 'paris',
                'name' => 'Paris',
                'country' => 'Frankreich',
                'description' => 'Die Stadt der Liebe mit weltberühmten Sehenswürdigkeiten, exquisiter Küche und unvergleichlichem Charme.',
                'image' => 'paris-1.jpg',
                'rating' => 4.8,
                'reviewCount' => 5678,
                'startingPrice' => 899,
                'popular' => true,
                'highlights' => ['Eiffelturm', 'Louvre', 'Champs-Élysées', 'Französische Küche']
            ],
            [
                'id' => 'tokyo',
                'name' => 'Tokio',
                'country' => 'Japan',
                'description' => 'Eine faszinierende Metropole, wo traditionelle Tempel auf futuristische Wolkenkratzer treffen.',
                'image' => 'tokyo.jpg',
                'rating' => 4.9,
                'reviewCount' => 3234,
                'startingPrice' => 1299,
                'popular' => true,
                'highlights' => ['Senso-ji Tempel', 'Shibuya Crossing', 'Mount Fuji Ausblick', 'Sushi-Märkte']
            ],
            [
                'id' => 'new-york',
                'name' => 'New York City',
                'country' => 'USA',
                'description' => 'Die Stadt, die niemals schläft - voller Energie, Kultur und ikonischen Wahrzeichen.',
                'image' => 'new-york.jpg',
                'rating' => 4.7,
                'reviewCount' => 6789,
                'startingPrice' => 1599,
                'popular' => true,
                'highlights' => ['Times Square', 'Central Park', 'Freiheitsstatue', 'Broadway Shows']
            ],
            [
                'id' => 'dubai',
                'name' => 'Dubai',
                'country' => 'VAE',
                'description' => 'Eine futuristische Oase mit beeindruckender Architektur, Luxus-Shopping und endlosen Wüstenerlebnissen.',
                'image' => 'dubai.jpg',
                'rating' => 4.6,
                'reviewCount' => 4567,
                'startingPrice' => 1199,
                'highlights' => ['Burj Khalifa', 'Dubai Mall', 'Wüstensafari', 'Palm Jumeirah']
            ],
            [
                'id' => 'bali',
                'name' => 'Bali',
                'country' => 'Indonesien',
                'description' => 'Die Insel der Götter mit üppigen Reisterrassen, heiligen Tempeln und traumhaften Stränden.',
                'image' => 'bali.jpg',
                'rating' => 4.8,
                'reviewCount' => 5432,
                'startingPrice' => 899,
                'highlights' => ['Reisterrassen', 'Hindu-Tempel', 'Surfstrände', 'Yoga-Retreats']
            ],
            [
                'id' => 'rome',
                'name' => 'Rom',
                'country' => 'Italien',
                'description' => 'Die ewige Stadt mit antiken Ruinen, Renaissance-Kunst und köstlicher italienischer Küche.',
                'image' => 'rome.jpg',
                'rating' => 4.9,
                'reviewCount' => 6123,
                'startingPrice' => 799,
                'highlights' => ['Kolosseum', 'Vatikan', 'Trevi-Brunnen', 'Pasta & Pizza']
            ],
            [
                'id' => 'santorini',
                'name' => 'Santorini',
                'country' => 'Griechenland',
                'description' => 'Eine malerische Vulkaninsel mit weißen Häusern, blauen Kuppeln und spektakulären Sonnenuntergängen.',
                'image' => 'santorini.jpg',
                'rating' => 4.9,
                'reviewCount' => 3890,
                'startingPrice' => 1099,
                'highlights' => ['Oia Sonnenuntergang', 'Vulkanstrände', 'Weinproben', 'Caldera-Blick']
            ],
            [
                'id' => 'london',
                'name' => 'London',
                'country' => 'Großbritannien',
                'description' => 'Eine historische Metropole mit königlichen Palästen, weltklasse Museen und britischem Charme.',
                'image' => 'london.jpg',
                'rating' => 4.7,
                'reviewCount' => 7234,
                'startingPrice' => 999,
                'highlights' => ['Big Ben', 'Tower Bridge', 'British Museum', 'West End Theater']
            ],
            [
                'id' => 'barcelona',
                'name' => 'Barcelona',
                'country' => 'Spanien',
                'description' => 'Eine lebendige Stadt mit Gaudís Meisterwerken, mediterranen Stränden und katalanischer Kultur.',
                'image' => 'barcelona.jpg',
                'rating' => 4.8,
                'reviewCount' => 5678,
                'startingPrice' => 799,
                'highlights' => ['Sagrada Familia', 'Park Güell', 'Las Ramblas', 'Tapas-Bars']
            ],
            [
                'id' => 'istanbul',
                'name' => 'Istanbul',
                'country' => 'Türkei',
                'description' => 'Die Stadt auf zwei Kontinenten mit byzantinischer Geschichte, osmanischer Pracht und lebhaften Basaren.',
                'image' => 'istanbul.jpg',
                'rating' => 4.7,
                'reviewCount' => 4321,
                'startingPrice' => 699,
                'highlights' => ['Hagia Sophia', 'Blauer Moschee', 'Großer Basar', 'Bosporus-Kreuzfahrt']
            ],
            [
                'id' => 'sydney',
                'name' => 'Sydney',
                'country' => 'Australien',
                'description' => 'Eine sonnige Hafenstadt mit ikonischer Architektur, goldenen Stränden und entspanntem Lebensstil.',
                'image' => 'sydney.jpg',
                'rating' => 4.8,
                'reviewCount' => 4890,
                'startingPrice' => 1799,
                'highlights' => ['Opera House', 'Harbour Bridge', 'Bondi Beach', 'Blue Mountains']
            ],
            [
                'id' => 'amsterdam',
                'name' => 'Amsterdam',
                'country' => 'Niederlande',
                'description' => 'Die Stadt der Grachten mit historischer Architektur, weltberühmten Museen und liberaler Atmosphäre.',
                'image' => 'amsterdam.jpg',
                'rating' => 4.6,
                'reviewCount' => 5123,
                'startingPrice' => 699,
                'highlights' => ['Grachtenfahrt', 'Van Gogh Museum', 'Anne Frank Haus', 'Fahrradtouren']
            ],
            [
                'id' => 'vienna',
                'name' => 'Wien',
                'country' => 'Österreich',
                'description' => 'Die imperiale Hauptstadt mit prächtigen Palästen, klassischer Musik und Kaffeehauskultur.',
                'image' => 'vienna.jpg',
                'rating' => 4.7,
                'reviewCount' => 3456,
                'startingPrice' => 799,
                'highlights' => ['Schönbrunn', 'Hofburg', 'Wiener Staatsoper', 'Sachertorte']
            ],
            [
                'id' => 'singapore',
                'name' => 'Singapur',
                'country' => 'Singapur',
                'description' => 'Ein moderner Stadtstaat mit futuristischen Gärten, vielfältiger Küche und tropischem Klima.',
                'image' => 'singapore.jpg',
                'rating' => 4.7,
                'reviewCount' => 4567,
                'startingPrice' => 1399,
                'highlights' => ['Marina Bay Sands', 'Gardens by the Bay', 'Hawker Centers', 'Sentosa Island']
            ],
            // Additional destinations without specific images - will use generic images
            [
                'id' => 'lisbon',
                'name' => 'Lissabon',
                'country' => 'Portugal',
                'description' => 'Eine charmante Hügelstadt mit bunten Kacheln, historischen Straßenbahnen und Fado-Musik.',
                'image' => 'city-historic.jpg',
                'rating' => 4.8,
                'reviewCount' => 3789,
                'startingPrice' => 599,
                'highlights' => ['Belém-Turm', 'Tram 28', 'Pastéis de Nata', 'Fado-Abende']
            ],
            [
                'id' => 'cairo',
                'name' => 'Kairo',
                'country' => 'Ägypten',
                'description' => 'Die Stadt der Pharaonen mit antiken Pyramiden, lebhaften Märkten und reicher Geschichte.',
                'image' => 'city-historic.jpg',
                'rating' => 4.5,
                'reviewCount' => 3234,
                'startingPrice' => 799,
                'highlights' => ['Pyramiden von Gizeh', 'Ägyptisches Museum', 'Khan el-Khalili', 'Nil-Kreuzfahrt']
            ],
            [
                'id' => 'bangkok',
                'name' => 'Bangkok',
                'country' => 'Thailand',
                'description' => 'Eine pulsierende Metropole mit goldenen Tempeln, schwimmenden Märkten und exotischem Street Food.',
                'image' => 'hero-beach.jpg',
                'rating' => 4.6,
                'reviewCount' => 5678,
                'startingPrice' => 799,
                'highlights' => ['Wat Pho', 'Großer Palast', 'Chatuchak Markt', 'Thai-Massage']
            ],
            [
                'id' => 'kyoto',
                'name' => 'Kyoto',
                'country' => 'Japan',
                'description' => 'Die alte Kaiserstadt mit tausenden Tempeln, traditionellen Geishas und zen-inspirierten Gärten.',
                'image' => 'mountains.jpg',
                'rating' => 4.9,
                'reviewCount' => 3678,
                'startingPrice' => 1199,
                'highlights' => ['Goldener Pavillon', 'Bambuswald', 'Geisha-Viertel', 'Kaiservilla']
            ],
            [
                'id' => 'edinburgh',
                'name' => 'Edinburgh',
                'country' => 'Schottland',
                'description' => 'Eine historische Stadt mit mittelalterlicher Burg, schottischen Traditionen und dramatischer Landschaft.',
                'image' => 'mountains.jpg',
                'rating' => 4.7,
                'reviewCount' => 2789,
                'startingPrice' => 799,
                'highlights' => ['Edinburgh Castle', 'Royal Mile', 'Arthur\'s Seat', 'Whisky-Touren']
            ],
            [
                'id' => 'reykjavik',
                'name' => 'Reykjavik',
                'country' => 'Island',
                'description' => 'Die nördlichste Hauptstadt mit Nordlichtern, heißen Quellen und vulkanischer Landschaft.',
                'image' => 'mountains.jpg',
                'rating' => 4.8,
                'reviewCount' => 1890,
                'startingPrice' => 1299,
                'highlights' => ['Nordlichter', 'Blaue Lagune', 'Goldener Kreis', 'Walbeobachtung']
            ],
            [
                'id' => 'oslo',
                'name' => 'Oslo',
                'country' => 'Norwegen',
                'description' => 'Eine grüne Hauptstadt mit Fjordblick, moderner Architektur und Wikinger-Geschichte.',
                'image' => 'mountains.jpg',
                'rating' => 4.6,
                'reviewCount' => 1890,
                'startingPrice' => 1199,
                'highlights' => ['Opernhaus', 'Vigeland-Park', 'Wikingerschiff-Museum', 'Holmenkollen']
            ],
            [
                'id' => 'zurich',
                'name' => 'Zürich',
                'country' => 'Schweiz',
                'description' => 'Eine wohlhabende Stadt am See mit Schweizer Präzision, Kunstszene und Alpenpanorama.',
                'image' => 'mountains.jpg',
                'rating' => 4.7,
                'reviewCount' => 2123,
                'startingPrice' => 1299,
                'highlights' => ['Zürichsee', 'Altstadt', 'Kunsthaus', 'Schweizer Uhren']
            ],
            [
                'id' => 'geneva',
                'name' => 'Genf',
                'country' => 'Schweiz',
                'description' => 'Die internationale Stadt am See mit UN-Hauptquartier, Jet d\'Eau und Alpenblick.',
                'image' => 'mountains.jpg',
                'rating' => 4.6,
                'reviewCount' => 1890,
                'startingPrice' => 1199,
                'highlights' => ['Genfer See', 'Jet d\'Eau', 'UN-Gebäude', 'CERN']
            ],
            [
                'id' => 'valencia',
                'name' => 'Valencia',
                'country' => 'Spanien',
                'description' => 'Eine sonnige Küstenstadt mit futuristischer Architektur, Paella und mediterranem Strand.',
                'image' => 'hero-beach.jpg',
                'rating' => 4.6,
                'reviewCount' => 2890,
                'startingPrice' => 699,
                'highlights' => ['Stadt der Künste', 'Altstadt', 'Paella Valenciana', 'Turia-Gärten']
            ],
            [
                'id' => 'nice',
                'name' => 'Nizza',
                'country' => 'Frankreich',
                'description' => 'Die Perle der Côte d\'Azur mit Strandpromenade, mediterranem Flair und französischer Riviera.',
                'image' => 'hero-beach.jpg',
                'rating' => 4.7,
                'reviewCount' => 3123,
                'startingPrice' => 899,
                'highlights' => ['Promenade des Anglais', 'Altstadt', 'Blumenmarkt', 'Monaco Tagesausflug']
            ]
        ];

        try {
            // Create or get the Destinations folder in Data Objects
            $parentFolder = Folder::getByPath('/Destinations');
            if (!$parentFolder) {
                $parentFolder = new Folder();
                $parentFolder->setKey('Destinations');
                $parentFolder->setParent(Service::createFolderByPath('/'));
                $parentFolder->save();
                $output->writeln('<info>Created folder: /Destinations</info>');
            }

            // Create or get the Destinations folder in Assets
            $assetParentFolder = Asset\Service::createFolderByPath('/Destinations');
            $output->writeln('<info>Assets folder ready: /Destinations</info>');

            // Copy images from travel project to Pimcore assets
            $sourceImagePath = '/var/www/html/public/var/assets/temp_import/';
            $processedImages = [];

            foreach ($destinations as $destination) {
                $imageName = $destination['image'];
                $sourceFile = $sourceImagePath . $imageName;
                
                // Check if image exists in source
                if (file_exists($sourceFile)) {
                    // Check if asset already exists
                    $assetPath = '/Destinations/' . $imageName;
                    $existingAsset = Asset::getByPath($assetPath);
                    
                    if (!$existingAsset) {
                        $asset = new Asset\Image();
                        $asset->setFilename($imageName);
                        $asset->setData(file_get_contents($sourceFile));
                        $asset->setParent($assetParentFolder);
                        $asset->save();
                        $output->writeln('<comment>Copied image: ' . $imageName . '</comment>');
                        $processedImages[$imageName] = $asset;
                    } else {
                        $processedImages[$imageName] = $existingAsset;
                        $output->writeln('Image already exists: ' . $imageName);
                    }
                } else {
                    $output->writeln('<error>Warning: Image not found: ' . $sourceFile . '</error>');
                }
            }

            // Create destination objects
            foreach ($destinations as $data) {
                $key = Service::getValidKey($data['name'], 'object');
                
                // Check if object already exists
                $existingObject = Destionation::getByPath('/Destinations/' . $key);
                
                if ($existingObject) {
                    $output->writeln('Destination already exists: ' . $data['name']);
                    continue;
                }

                $destination = new Destionation();
                $destination->setKey($key);
                $destination->setParent($parentFolder);
                $destination->setPublished(true);
                
                // Set basic fields
                $destination->setName($data['name']);
                $destination->setCountry($data['country']);
                $destination->setDescription($data['description']);
                $destination->setPrice('ab €' . $data['startingPrice']);
                $destination->setRating($data['rating']);
                $destination->setReviews($data['reviewCount']);
                
                // Set tag
                if (isset($data['popular']) && $data['popular']) {
                    $destination->setTag('Beliebt');
                }
                
                // Set main image
                if (isset($processedImages[$data['image']])) {
                    $destination->setImage($processedImages[$data['image']]);
                }
                
                // Set highlights
                if (!empty($data['highlights'])) {
                    $destination->setHighlights($data['highlights']);
                }
                
                // Set long description (using description for now)
                $longDesc = '<p>' . $data['description'] . '</p>';
                $longDesc .= '<h3>Highlights</h3><ul>';
                foreach ($data['highlights'] as $highlight) {
                    $longDesc .= '<li>' . $highlight . '</li>';
                }
                $longDesc .= '</ul>';
                $destination->setLongDescription($longDesc);
                
                $destination->save();
                $output->writeln('<info>Created destination: ' . $data['name'] . '</info>');
            }
            
            $output->writeln('');
            $output->writeln('<info>✅ Import completed successfully!</info>');
            $output->writeln('<info>Created ' . count($destinations) . ' destinations in /Destinations</info>');
            $output->writeln('<info>Uploaded images to /Assets/Destinations</info>');

            return self::SUCCESS;

        } catch (\Exception $e) {
            $output->writeln('<error>Error: ' . $e->getMessage() . '</error>');
            $output->writeln($e->getTraceAsString());
            return self::FAILURE;
        }
    }
}