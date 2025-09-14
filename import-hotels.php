<?php

use Pimcore\Model\DataObject\Hotel;
use Pimcore\Model\DataObject\Service;
use Pimcore\Model\Asset;

// Bootstrap Pimcore
include_once 'vendor/autoload.php';
\Pimcore\Bootstrap::setProjectRoot();
\Pimcore\Bootstrap::bootstrap();

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
        'featured' => true,
        'category' => 'Luxury',
        'rooms' => 320,
        'checkInTime' => '15:00',
        'checkOutTime' => '12:00'
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
        'featured' => true,
        'category' => 'Mountain Resort',
        'rooms' => 145,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
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
        'featured' => true,
        'category' => 'Beach Resort',
        'rooms' => 80,
        'checkInTime' => '14:00',
        'checkOutTime' => '12:00'
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
        'featured' => false,
        'category' => 'Boutique',
        'rooms' => 45,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
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
        'featured' => true,
        'category' => 'City Hotel',
        'rooms' => 280,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
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
        'featured' => false,
        'category' => 'Historic',
        'rooms' => 195,
        'checkInTime' => '14:00',
        'checkOutTime' => '12:00'
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
        'featured' => true,
        'category' => 'Beach Resort',
        'rooms' => 450,
        'checkInTime' => '15:00',
        'checkOutTime' => '12:00'
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
        'featured' => false,
        'category' => 'Boutique',
        'rooms' => 25,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
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
        'featured' => false,
        'category' => 'Luxury',
        'rooms' => 380,
        'checkInTime' => '15:00',
        'checkOutTime' => '12:00'
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
        'featured' => false,
        'category' => 'Eco Resort',
        'rooms' => 35,
        'checkInTime' => '14:00',
        'checkOutTime' => '12:00'
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
        'featured' => false,
        'category' => 'Boutique',
        'rooms' => 85,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
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
        'featured' => false,
        'category' => 'Historic',
        'rooms' => 160,
        'checkInTime' => '14:00',
        'checkOutTime' => '12:00'
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
        'featured' => false,
        'category' => 'Boutique',
        'rooms' => 40,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
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
        'featured' => true,
        'category' => 'Luxury',
        'rooms' => 560,
        'checkInTime' => '15:00',
        'checkOutTime' => '12:00'
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
        'featured' => false,
        'category' => 'Historic',
        'rooms' => 75,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
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
        'featured' => false,
        'category' => 'Historic',
        'rooms' => 120,
        'checkInTime' => '14:00',
        'checkOutTime' => '12:00'
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
        'featured' => false,
        'category' => 'City Hotel',
        'rooms' => 290,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
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
        'featured' => false,
        'category' => 'Boutique',
        'rooms' => 55,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
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
        'featured' => false,
        'category' => 'Design Hotel',
        'rooms' => 110,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
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
        'featured' => false,
        'category' => 'Boutique',
        'rooms' => 20,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ]
];

// Additional hotels (continuing with rest of data)
$additionalHotels = [
    [
        'id' => 'reykjavik-northern',
        'name' => 'Northern Lights Hotel',
        'location' => 'Reykjavik, Island',
        'country' => 'Island',
        'description' => 'Modernes Hotel mit Glasdach-Suiten für Nordlicht-Beobachtungen.',
        'rating' => 4.8,
        'reviewCount' => 876,
        'pricePerNight' => 325,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Spa', 'Hot Tub', 'Northern Lights Wake-up Call'],
        'featured' => false,
        'category' => 'Unique',
        'rooms' => 65,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'moscow-grand',
        'name' => 'Grand Hotel Moscow',
        'location' => 'Moskau, Russland',
        'country' => 'Russland',
        'description' => 'Prachtvolles Hotel am Roten Platz mit Blick auf den Kreml.',
        'rating' => 4.6,
        'reviewCount' => 1678,
        'pricePerNight' => 310,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Spa', 'Fitness', 'Business Center', 'Concierge'],
        'featured' => false,
        'category' => 'Luxury',
        'rooms' => 245,
        'checkInTime' => '14:00',
        'checkOutTime' => '12:00'
    ],
    [
        'id' => 'buenos-aires-tango',
        'name' => 'Tango Palace Buenos Aires',
        'location' => 'Buenos Aires, Argentinien',
        'country' => 'Argentinien',
        'description' => 'Elegantes Hotel im San Telmo Viertel mit Tango-Shows und Milonga.',
        'rating' => 4.5,
        'reviewCount' => 1098,
        'pricePerNight' => 145,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Tango Shows', 'Dance Classes', 'Wine Bar'],
        'featured' => false,
        'category' => 'Cultural',
        'rooms' => 90,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'cape-town-table',
        'name' => 'Table Mountain Lodge',
        'location' => 'Kapstadt, Südafrika',
        'country' => 'Südafrika',
        'description' => 'Luxuslodge mit Blick auf den Tafelberg und die Twelve Apostles.',
        'rating' => 4.9,
        'reviewCount' => 1432,
        'pricePerNight' => 295,
        'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Wine Tasting', 'Safari Tours'],
        'featured' => false,
        'category' => 'Lodge',
        'rooms' => 50,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'helsinki-design',
        'name' => 'Nordic Design Hotel',
        'location' => 'Helsinki, Finnland',
        'country' => 'Finnland',
        'description' => 'Minimalistisches Design-Hotel mit finnischer Sauna und Blick auf die Ostsee.',
        'rating' => 4.6,
        'reviewCount' => 789,
        'pricePerNight' => 265,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Sauna', 'Fitness', 'Bike Rental'],
        'featured' => false,
        'category' => 'Design Hotel',
        'rooms' => 125,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'dublin-castle',
        'name' => 'Dublin Castle Hotel',
        'location' => 'Dublin, Irland',
        'country' => 'Irland',
        'description' => 'Historisches Schlosshotel mit irischem Charme und Whiskey-Bar.',
        'rating' => 4.7,
        'reviewCount' => 1234,
        'pricePerNight' => 225,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Whiskey Lounge', 'Library', 'Golf Course'],
        'featured' => false,
        'category' => 'Castle',
        'rooms' => 100,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'seoul-modern',
        'name' => 'Modern Seoul Hotel',
        'location' => 'Seoul, Südkorea',
        'country' => 'Südkorea',
        'description' => 'Hochmodernes Hotel im Gangnam-Viertel mit K-Spa und koreanischem BBQ.',
        'rating' => 4.8,
        'reviewCount' => 1876,
        'pricePerNight' => 255,
        'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'K-Spa', 'Karaoke', 'Shopping'],
        'featured' => false,
        'category' => 'City Hotel',
        'rooms' => 320,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'mumbai-palace',
        'name' => 'Mumbai Palace Hotel',
        'location' => 'Mumbai, Indien',
        'country' => 'Indien',
        'description' => 'Palasthotel im kolonialen Stil mit Blick auf das Gateway of India.',
        'rating' => 4.6,
        'reviewCount' => 2109,
        'pricePerNight' => 195,
        'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Ayurveda Center', 'Yoga'],
        'featured' => false,
        'category' => 'Heritage',
        'rooms' => 285,
        'checkInTime' => '14:00',
        'checkOutTime' => '12:00'
    ],
    [
        'id' => 'vancouver-mountain',
        'name' => 'Mountain View Vancouver',
        'location' => 'Vancouver, Kanada',
        'country' => 'Kanada',
        'description' => 'Modernes Hotel mit Blick auf die North Shore Mountains und den Pazifik.',
        'rating' => 4.7,
        'reviewCount' => 1543,
        'pricePerNight' => 285,
        'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Fitness', 'Ski Storage'],
        'featured' => false,
        'category' => 'City Hotel',
        'rooms' => 210,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'edinburgh-royal',
        'name' => 'Royal Mile Hotel',
        'location' => 'Edinburgh, Schottland',
        'country' => 'Schottland',
        'description' => 'Traditionelles Hotel auf der Royal Mile mit Blick auf Edinburgh Castle.',
        'rating' => 4.6,
        'reviewCount' => 1321,
        'pricePerNight' => 215,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Whisky Bar', 'Library', 'Concierge'],
        'featured' => false,
        'category' => 'Historic',
        'rooms' => 95,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'mexico-beach',
        'name' => 'Playa Paradise Cancun',
        'location' => 'Cancun, Mexiko',
        'country' => 'Mexiko',
        'description' => 'All-Inclusive Strandresort mit weißem Sand und türkisblauem Wasser.',
        'rating' => 4.7,
        'reviewCount' => 2345,
        'pricePerNight' => 320,
        'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Beach Club', 'Water Sports', 'Kids Club'],
        'featured' => false,
        'category' => 'Beach Resort',
        'rooms' => 380,
        'checkInTime' => '15:00',
        'checkOutTime' => '12:00'
    ],
    [
        'id' => 'brussels-grand',
        'name' => 'Grand Place Hotel Brussels',
        'location' => 'Brüssel, Belgien',
        'country' => 'Belgien',
        'description' => 'Elegantes Hotel am Grand Place mit belgischer Brasserie und Chocolaterie.',
        'rating' => 4.5,
        'reviewCount' => 987,
        'pricePerNight' => 195,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Chocolaterie', 'Beer Lounge', 'Concierge'],
        'featured' => false,
        'category' => 'City Hotel',
        'rooms' => 110,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'stockholm-gamla',
        'name' => 'Gamla Stan Hotel',
        'location' => 'Stockholm, Schweden',
        'country' => 'Schweden',
        'description' => 'Charmantes Hotel in der Altstadt mit skandinavischem Design.',
        'rating' => 4.6,
        'reviewCount' => 1123,
        'pricePerNight' => 275,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Sauna', 'Library', 'Bike Rental'],
        'featured' => false,
        'category' => 'Boutique',
        'rooms' => 60,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'athens-acropolis',
        'name' => 'Acropolis View Hotel',
        'location' => 'Athen, Griechenland',
        'country' => 'Griechenland',
        'description' => 'Modernes Hotel mit Dachterrasse und Blick auf die Akropolis.',
        'rating' => 4.7,
        'reviewCount' => 1654,
        'pricePerNight' => 165,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Rooftop', 'Pool', 'Museum Tours'],
        'featured' => false,
        'category' => 'City Hotel',
        'rooms' => 145,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'oslo-fjord',
        'name' => 'Fjord View Hotel Oslo',
        'location' => 'Oslo, Norwegen',
        'country' => 'Norwegen',
        'description' => 'Modernes Hotel am Oslofjord mit nordischem Spa und Michelin-Restaurant.',
        'rating' => 4.8,
        'reviewCount' => 1098,
        'pricePerNight' => 345,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Spa', 'Sauna', 'Fitness', 'Boat Tours'],
        'featured' => false,
        'category' => 'Luxury',
        'rooms' => 180,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'budapest-thermal',
        'name' => 'Thermal Spa Hotel Budapest',
        'location' => 'Budapest, Ungarn',
        'country' => 'Ungarn',
        'description' => 'Art Nouveau Hotel mit eigenem Thermalbad und Blick auf die Donau.',
        'rating' => 4.6,
        'reviewCount' => 1432,
        'pricePerNight' => 175,
        'amenities' => ['WiFi', 'Thermal Bath', 'Spa', 'Restaurant', 'Bar', 'Massage', 'Wellness'],
        'featured' => false,
        'category' => 'Spa Hotel',
        'rooms' => 165,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'warsaw-palace',
        'name' => 'Warsaw Palace Hotel',
        'location' => 'Warschau, Polen',
        'country' => 'Polen',
        'description' => 'Restaurierter Palast in der Altstadt mit polnischer Küche und Chopin-Konzerten.',
        'rating' => 4.5,
        'reviewCount' => 876,
        'pricePerNight' => 135,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Concert Hall', 'Library', 'Garden'],
        'featured' => false,
        'category' => 'Historic',
        'rooms' => 85,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'zagreb-art',
        'name' => 'Art Hotel Zagreb',
        'location' => 'Zagreb, Kroatien',
        'country' => 'Kroatien',
        'description' => 'Kunsthotel im Stadtzentrum mit Galerie und kroatischem Design.',
        'rating' => 4.4,
        'reviewCount' => 654,
        'pricePerNight' => 115,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Art Gallery', 'Terrace', 'Bike Rental'],
        'featured' => false,
        'category' => 'Art Hotel',
        'rooms' => 70,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'valencia-beach',
        'name' => 'Valencia Beach Resort',
        'location' => 'Valencia, Spanien',
        'country' => 'Spanien',
        'description' => 'Strandresort mit Blick auf das Mittelmeer und Paella-Restaurant.',
        'rating' => 4.6,
        'reviewCount' => 1234,
        'pricePerNight' => 185,
        'amenities' => ['WiFi', 'Pool', 'Beach', 'Restaurant', 'Bar', 'Water Sports', 'Bike Rental'],
        'featured' => false,
        'category' => 'Beach Hotel',
        'rooms' => 155,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'krakow-jewish',
        'name' => 'Jewish Quarter Hotel Krakow',
        'location' => 'Krakau, Polen',
        'country' => 'Polen',
        'description' => 'Boutique-Hotel im historischen jüdischen Viertel Kazimierz.',
        'rating' => 4.5,
        'reviewCount' => 789,
        'pricePerNight' => 95,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Library', 'Cultural Tours', 'Airport Shuttle'],
        'featured' => false,
        'category' => 'Boutique',
        'rooms' => 45,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'nice-riviera',
        'name' => 'Riviera Palace Nice',
        'location' => 'Nizza, Frankreich',
        'country' => 'Frankreich',
        'description' => 'Belle Époque Hotel an der Promenade des Anglais mit Meerblick.',
        'rating' => 4.7,
        'reviewCount' => 1567,
        'pricePerNight' => 325,
        'amenities' => ['WiFi', 'Pool', 'Beach', 'Restaurant', 'Bar', 'Spa', 'Casino Access'],
        'featured' => false,
        'category' => 'Luxury',
        'rooms' => 195,
        'checkInTime' => '15:00',
        'checkOutTime' => '12:00'
    ],
    [
        'id' => 'cologne-cathedral',
        'name' => 'Cathedral Hotel Cologne',
        'location' => 'Köln, Deutschland',
        'country' => 'Deutschland',
        'description' => 'Historisches Hotel mit Blick auf den Kölner Dom und rheinische Gastfreundschaft.',
        'rating' => 4.6,
        'reviewCount' => 1321,
        'pricePerNight' => 165,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Beer Garden', 'Cathedral Tours', 'Parking'],
        'featured' => false,
        'category' => 'City Hotel',
        'rooms' => 125,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'geneva-lake',
        'name' => 'Lake Geneva Grand Hotel',
        'location' => 'Genf, Schweiz',
        'country' => 'Schweiz',
        'description' => 'Elegantes Hotel am Genfer See mit Alpenblick und Gourmet-Restaurants.',
        'rating' => 4.8,
        'reviewCount' => 1876,
        'pricePerNight' => 425,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Spa', 'Fitness', 'Boat Tours', 'Concierge'],
        'featured' => false,
        'category' => 'Luxury',
        'rooms' => 235,
        'checkInTime' => '15:00',
        'checkOutTime' => '12:00'
    ],
    [
        'id' => 'porto-wine',
        'name' => 'Port Wine Hotel Porto',
        'location' => 'Porto, Portugal',
        'country' => 'Portugal',
        'description' => 'Boutique-Hotel in einem ehemaligen Weinkeller mit Verkostungsraum.',
        'rating' => 4.6,
        'reviewCount' => 1098,
        'pricePerNight' => 155,
        'amenities' => ['WiFi', 'Restaurant', 'Wine Bar', 'Wine Tasting', 'Cellar Tours', 'Terrace'],
        'featured' => false,
        'category' => 'Wine Hotel',
        'rooms' => 55,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'salzburg-mozart',
        'name' => 'Mozart Residence Salzburg',
        'location' => 'Salzburg, Österreich',
        'country' => 'Österreich',
        'description' => 'Barockes Hotel in der Altstadt mit Konzertsaal und österreichischer Küche.',
        'rating' => 4.7,
        'reviewCount' => 1432,
        'pricePerNight' => 225,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Concert Hall', 'Music Library', 'Garden'],
        'featured' => false,
        'category' => 'Cultural',
        'rooms' => 105,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'milan-fashion',
        'name' => 'Fashion District Hotel Milan',
        'location' => 'Mailand, Italien',
        'country' => 'Italien',
        'description' => 'Stylisches Hotel im Modeviertel mit Designer-Suiten und Rooftop-Bar.',
        'rating' => 4.7,
        'reviewCount' => 1654,
        'pricePerNight' => 295,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Rooftop', 'Spa', 'Personal Shopper', 'Fashion Tours'],
        'featured' => false,
        'category' => 'Design Hotel',
        'rooms' => 140,
        'checkInTime' => '15:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'havana-colonial',
        'name' => 'Colonial Havana Hotel',
        'location' => 'Havanna, Kuba',
        'country' => 'Kuba',
        'description' => 'Koloniales Herrenhaus in Alt-Havanna mit Zigarren-Lounge und Salsa-Bar.',
        'rating' => 4.5,
        'reviewCount' => 876,
        'pricePerNight' => 125,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Cigar Lounge', 'Salsa Classes', 'Vintage Car Tours'],
        'featured' => false,
        'category' => 'Heritage',
        'rooms' => 65,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'zurich-business',
        'name' => 'Business Hotel Zurich',
        'location' => 'Zürich, Schweiz',
        'country' => 'Schweiz',
        'description' => 'Modernes Business-Hotel nahe dem Finanzviertel mit erstklassigen Konferenzräumen.',
        'rating' => 4.6,
        'reviewCount' => 1543,
        'pricePerNight' => 385,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Business Center', 'Conference Rooms', 'Fitness', 'Parking'],
        'featured' => false,
        'category' => 'Business',
        'rooms' => 220,
        'checkInTime' => '14:00',
        'checkOutTime' => '12:00'
    ],
    [
        'id' => 'florence-renaissance',
        'name' => 'Renaissance Palace Florence',
        'location' => 'Florenz, Italien',
        'country' => 'Italien',
        'description' => 'Renaissance-Palast mit Fresken, Kunstsammlung und toskanischer Küche.',
        'rating' => 4.8,
        'reviewCount' => 1987,
        'pricePerNight' => 275,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Art Gallery', 'Garden', 'Wine Cellar', 'Art Tours'],
        'featured' => false,
        'category' => 'Historic',
        'rooms' => 95,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ],
    [
        'id' => 'belgrade-danube',
        'name' => 'Danube View Belgrade',
        'location' => 'Belgrad, Serbien',
        'country' => 'Serbien',
        'description' => 'Modernes Hotel an der Donau mit serbischer Gastfreundschaft und Balkan-Küche.',
        'rating' => 4.4,
        'reviewCount' => 543,
        'pricePerNight' => 85,
        'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Terrace', 'Fitness', 'River Cruise'],
        'featured' => false,
        'category' => 'City Hotel',
        'rooms' => 110,
        'checkInTime' => '14:00',
        'checkOutTime' => '11:00'
    ]
];

// Merge both arrays
$allHotels = array_merge($hotels, $additionalHotels);

// Get the parent folder for hotels
$parentId = 1; // Change this ID to your Hotels folder ID

echo "Starting hotel import...\n";
echo "Total hotels to import: " . count($allHotels) . "\n\n";

$successCount = 0;
$errorCount = 0;

foreach ($allHotels as $hotelData) {
    try {
        // Check if hotel already exists
        $existingHotel = Hotel::getByPath('/Hotels/' . $hotelData['id']);

        if ($existingHotel) {
            echo "Hotel already exists: " . $hotelData['name'] . " - Updating...\n";
            $hotel = $existingHotel;
        } else {
            // Create new hotel object
            $hotel = new Hotel();
            $hotel->setKey($hotelData['id']);
            $hotel->setParentId($parentId);
            echo "Creating new hotel: " . $hotelData['name'] . "\n";
        }

        // Set hotel properties
        $hotel->setLocation($hotelData['location']);
        $hotel->setRating($hotelData['rating']);
        $hotel->setReviewCount($hotelData['reviewCount']);
        $hotel->setPrice($hotelData['pricePerNight']);

        // Set featured checkbox
        $hotel->setFeatured($hotelData['featured']);

        // Set amenities (multiselect)
        $hotel->setAmenities(implode(',', $hotelData['amenities']));

        // Set localized fields (name and description)
        $hotel->setName($hotelData['name'], 'de');
        $hotel->setDescription($hotelData['description'], 'de');

        // Publish the hotel
        $hotel->setPublished(true);

        // Save the hotel
        $hotel->save();

        $successCount++;
        echo "✓ Successfully imported: " . $hotelData['name'] . "\n";

    } catch (\Exception $e) {
        $errorCount++;
        echo "✗ Error importing " . $hotelData['name'] . ": " . $e->getMessage() . "\n";
    }
}

echo "\n=================================\n";
echo "Import completed!\n";
echo "Successfully imported: $successCount hotels\n";
echo "Errors: $errorCount\n";
echo "=================================\n";