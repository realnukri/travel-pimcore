<?php

use Pimcore\Model\DataObject;

require_once __DIR__ . '/vendor/autoload.php';

\Pimcore\Bootstrap::autoload();
$bootstrap = \Pimcore\Bootstrap::bootstrap();

// List all Flight objects
$flightListing = new DataObject\Flight\Listing();
$flightListing->setLimit(5);
$flights = $flightListing->load();

echo "Total flights in database: " . $flightListing->getTotalCount() . "\n\n";
echo "First 5 flights:\n";
echo str_repeat("-", 80) . "\n";

foreach ($flights as $flight) {
    echo sprintf(
        "Flight: %s\n  From: %s → To: %s\n  Airline: %s\n  Departure: %s → Arrival: %s\n  Price: €%s\n  Rating: %s\n\n",
        $flight->getKey(),
        $flight->getFrom(),
        $flight->getTo(),
        $flight->getAirline('de'),
        $flight->getDepartureTime(),
        $flight->getArrivalTime(),
        $flight->getPrice(),
        $flight->getRating()
    );
}