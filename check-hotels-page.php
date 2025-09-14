<?php

use Pimcore\Model\Document;

// Bootstrap Pimcore
include_once 'vendor/autoload.php';
\Pimcore\Bootstrap::setProjectRoot();
\Pimcore\Bootstrap::bootstrap();

echo "Checking for hotels page...\n\n";

// Try to find hotels page
$hotelsPaths = [
    '/hotels',
    '/Hotels',
    '/de/hotels',
    '/en/hotels',
    '/hotel',
    '/Hotel'
];

foreach ($hotelsPaths as $path) {
    $doc = Document::getByPath($path);
    if ($doc) {
        echo "Found document at path: $path\n";
        echo "Document Type: " . get_class($doc) . "\n";
        echo "Document ID: " . $doc->getId() . "\n";

        if ($doc instanceof \Pimcore\Model\Document\Page) {
            echo "Controller: " . $doc->getController() . "\n";
            echo "Action: " . $doc->getAction() . "\n";
            echo "Template: " . $doc->getTemplate() . "\n";
        }

        echo "Published: " . ($doc->getPublished() ? 'Yes' : 'No') . "\n";
        echo "\n";
    }
}

// List all pages
echo "\nAll available pages:\n";
echo "===================\n";

$listing = new Document\Listing();
$listing->setCondition("type = 'page'");
$listing->setOrderKey("path");
$listing->setOrder("ASC");

foreach ($listing as $doc) {
    echo "Path: " . $doc->getFullPath() . "\n";
    if ($doc instanceof \Pimcore\Model\Document\Page) {
        echo "  Controller: " . $doc->getController() . "\n";
        echo "  Action: " . $doc->getAction() . "\n";
    }
    echo "\n";
}