<?php

use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\ClassDefinition\Layout;

// Bootstrap Pimcore
$pimcorePath = __DIR__ . '/vendor/autoload.php';
require_once $pimcorePath;

\Pimcore\Bootstrap::setProjectRoot();
\Pimcore\Bootstrap::bootstrap();

function createDestinationClass() {
    try {
        // Check if class already exists
        $existingClass = ClassDefinition::getByName('Destination');
        if ($existingClass) {
            echo "Destination class already exists, skipping...\n";
            return;
        }

        $class = new ClassDefinition();
        $class->setName('Destination');
        $class->setUserOwner(1);
        $class->setUserModification(1);
        $class->setParentClass('');
        $class->setAllowInherit(false);
        $class->setAllowVariants(false);
        $class->setShowVariants(false);
        $class->setIcon('/bundles/pimcoreadmin/img/flat-color-icons/world.svg');
        $class->setGroup('Travel');

        // Create layout
        $layout = new Layout\Panel();
        $layout->setName('Layout');
        $layout->setTitle('Layout');
        
        // Basic Data Panel
        $basicDataPanel = new Layout\Panel();
        $basicDataPanel->setName('Basic Data');
        $basicDataPanel->setTitle('Basic Data');
        
        // Name field
        $nameField = new Data\Input();
        $nameField->setName('name');
        $nameField->setTitle('Name');
        $nameField->setMandatory(true);
        $nameField->setVisibleGridView(true);
        $nameField->setVisibleSearch(true);
        
        // Country field
        $countryField = new Data\Input();
        $countryField->setName('country');
        $countryField->setTitle('Country');
        $countryField->setMandatory(true);
        $countryField->setVisibleGridView(true);
        $countryField->setVisibleSearch(true);
        
        // Description field
        $descriptionField = new Data\Textarea();
        $descriptionField->setName('description');
        $descriptionField->setTitle('Description');
        $descriptionField->setVisibleGridView(false);
        $descriptionField->setVisibleSearch(false);
        
        // Image field
        $imageField = new Data\Image();
        $imageField->setName('image');
        $imageField->setTitle('Image');
        
        $basicDataPanel->setChildren([
            $nameField,
            $countryField,
            $descriptionField,
            $imageField
        ]);
        
        // Ratings & Reviews Panel
        $ratingsPanel = new Layout\Panel();
        $ratingsPanel->setName('Ratings & Reviews');
        $ratingsPanel->setTitle('Ratings & Reviews');
        
        // Rating field
        $ratingField = new Data\Numeric();
        $ratingField->setName('rating');
        $ratingField->setTitle('Rating');
        $ratingField->setMinValue(0);
        $ratingField->setMaxValue(5);
        $ratingField->setDecimalPrecision(1);
        $ratingField->setVisibleGridView(true);
        $ratingField->setVisibleSearch(true);
        
        // Review Count field
        $reviewCountField = new Data\Numeric();
        $reviewCountField->setName('reviewCount');
        $reviewCountField->setTitle('Review Count');
        $reviewCountField->setInteger(true);
        $reviewCountField->setMinValue(0);
        $reviewCountField->setDefaultValue(0);
        $reviewCountField->setVisibleGridView(true);
        $reviewCountField->setVisibleSearch(true);
        
        $ratingsPanel->setChildren([
            $ratingField,
            $reviewCountField
        ]);
        
        // Pricing & Features Panel
        $pricingPanel = new Layout\Panel();
        $pricingPanel->setName('Pricing & Features');
        $pricingPanel->setTitle('Pricing & Features');
        
        // Starting Price field
        $priceField = new Data\Numeric();
        $priceField->setName('startingPrice');
        $priceField->setTitle('Starting Price');
        $priceField->setMinValue(0);
        $priceField->setDecimalPrecision(2);
        $priceField->setVisibleGridView(true);
        $priceField->setVisibleSearch(true);
        
        // Popular field
        $popularField = new Data\Checkbox();
        $popularField->setName('popular');
        $popularField->setTitle('Popular');
        $popularField->setDefaultValue(false);
        $popularField->setVisibleGridView(true);
        $popularField->setVisibleSearch(true);
        
        // Highlights field
        $highlightsField = new Data\Multiselect();
        $highlightsField->setName('highlights');
        $highlightsField->setTitle('Highlights');
        $highlightsField->setOptions([
            ['key' => 'Luxus-Resorts', 'value' => 'Luxus-Resorts'],
            ['key' => 'Wassersport', 'value' => 'Wassersport'],
            ['key' => 'Romantik', 'value' => 'Romantik'],
            ['key' => 'Spa & Wellness', 'value' => 'Spa & Wellness'],
            ['key' => 'Skifahren', 'value' => 'Skifahren'],
            ['key' => 'Wandern', 'value' => 'Wandern'],
            ['key' => 'Alpine Kultur', 'value' => 'Alpine Kultur'],
            ['key' => 'Bergbahnen', 'value' => 'Bergbahnen'],
            ['key' => 'Historische Altstadt', 'value' => 'Historische Altstadt'],
            ['key' => 'Kultur', 'value' => 'Kultur'],
            ['key' => 'Nachtleben', 'value' => 'Nachtleben'],
            ['key' => 'Günstige Preise', 'value' => 'Günstige Preise'],
            ['key' => 'Strände', 'value' => 'Strände'],
            ['key' => 'Yoga', 'value' => 'Yoga'],
            ['key' => 'Moderne Kultur', 'value' => 'Moderne Kultur'],
            ['key' => 'Kulinarik', 'value' => 'Kulinarik'],
            ['key' => 'Shopping', 'value' => 'Shopping'],
            ['key' => 'Technologie', 'value' => 'Technologie'],
            ['key' => 'Sonnenuntergänge', 'value' => 'Sonnenuntergänge'],
            ['key' => 'Vulkan', 'value' => 'Vulkan'],
            ['key' => 'Weinkultur', 'value' => 'Weinkultur']
        ]);
        
        $pricingPanel->setChildren([
            $priceField,
            $popularField,
            $highlightsField
        ]);
        
        $layout->setChildren([
            $basicDataPanel,
            $ratingsPanel,
            $pricingPanel
        ]);
        
        $class->setLayoutDefinitions($layout);
        $class->save();
        
        echo "Destination class created successfully!\n";
    } catch (\Exception $e) {
        echo "Error creating Destination class: " . $e->getMessage() . "\n";
    }
}

function createHotelClass() {
    try {
        // Check if class already exists
        $existingClass = ClassDefinition::getByName('Hotel');
        if ($existingClass) {
            echo "Hotel class already exists, skipping...\n";
            return;
        }

        $class = new ClassDefinition();
        $class->setName('Hotel');
        $class->setUserOwner(1);
        $class->setUserModification(1);
        $class->setParentClass('');
        $class->setAllowInherit(false);
        $class->setAllowVariants(false);
        $class->setShowVariants(false);
        $class->setIcon('/bundles/pimcoreadmin/img/flat-color-icons/hotel.svg');
        $class->setGroup('Travel');

        // Create layout
        $layout = new Layout\Panel();
        $layout->setName('Layout');
        $layout->setTitle('Layout');
        
        // Basic Information Panel
        $basicPanel = new Layout\Panel();
        $basicPanel->setName('Basic Information');
        $basicPanel->setTitle('Basic Information');
        
        // Name field
        $nameField = new Data\Input();
        $nameField->setName('name');
        $nameField->setTitle('Hotel Name');
        $nameField->setMandatory(true);
        $nameField->setVisibleGridView(true);
        $nameField->setVisibleSearch(true);
        
        // Location field
        $locationField = new Data\Input();
        $locationField->setName('location');
        $locationField->setTitle('Location');
        $locationField->setMandatory(true);
        $locationField->setVisibleGridView(true);
        $locationField->setVisibleSearch(true);
        
        // Description field
        $descriptionField = new Data\Textarea();
        $descriptionField->setName('description');
        $descriptionField->setTitle('Description');
        
        // Image field
        $imageField = new Data\Image();
        $imageField->setName('image');
        $imageField->setTitle('Hotel Image');
        
        $basicPanel->setChildren([
            $nameField,
            $locationField,
            $descriptionField,
            $imageField
        ]);
        
        // Ratings & Reviews Panel
        $ratingsPanel = new Layout\Panel();
        $ratingsPanel->setName('Ratings & Reviews');
        $ratingsPanel->setTitle('Ratings & Reviews');
        
        // Rating field
        $ratingField = new Data\Numeric();
        $ratingField->setName('rating');
        $ratingField->setTitle('Rating');
        $ratingField->setMinValue(0);
        $ratingField->setMaxValue(5);
        $ratingField->setDecimalPrecision(1);
        $ratingField->setVisibleGridView(true);
        $ratingField->setVisibleSearch(true);
        
        // Review Count field
        $reviewCountField = new Data\Numeric();
        $reviewCountField->setName('reviewCount');
        $reviewCountField->setTitle('Review Count');
        $reviewCountField->setInteger(true);
        $reviewCountField->setMinValue(0);
        $reviewCountField->setDefaultValue(0);
        $reviewCountField->setVisibleGridView(true);
        $reviewCountField->setVisibleSearch(true);
        
        $ratingsPanel->setChildren([
            $ratingField,
            $reviewCountField
        ]);
        
        // Pricing Panel
        $pricingPanel = new Layout\Panel();
        $pricingPanel->setName('Pricing');
        $pricingPanel->setTitle('Pricing');
        
        // Price per Night field
        $priceField = new Data\Numeric();
        $priceField->setName('price');
        $priceField->setTitle('Price per Night');
        $priceField->setMinValue(0);
        $priceField->setDecimalPrecision(2);
        $priceField->setVisibleGridView(true);
        $priceField->setVisibleSearch(true);
        
        // Original Price field
        $originalPriceField = new Data\Numeric();
        $originalPriceField->setName('originalPrice');
        $originalPriceField->setTitle('Original Price');
        $originalPriceField->setMinValue(0);
        $originalPriceField->setDecimalPrecision(2);
        
        $pricingPanel->setChildren([
            $priceField,
            $originalPriceField
        ]);
        
        // Features & Amenities Panel
        $featuresPanel = new Layout\Panel();
        $featuresPanel->setName('Features & Amenities');
        $featuresPanel->setTitle('Features & Amenities');
        
        // Featured field
        $featuredField = new Data\Checkbox();
        $featuredField->setName('featured');
        $featuredField->setTitle('Featured Hotel');
        $featuredField->setDefaultValue(false);
        $featuredField->setVisibleGridView(true);
        $featuredField->setVisibleSearch(true);
        
        // Amenities field
        $amenitiesField = new Data\Multiselect();
        $amenitiesField->setName('amenities');
        $amenitiesField->setTitle('Amenities');
        $amenitiesField->setOptions([
            ['key' => 'Wifi', 'value' => 'Wifi'],
            ['key' => 'Parkplatz', 'value' => 'Parkplatz'],
            ['key' => 'Restaurant', 'value' => 'Restaurant'],
            ['key' => 'Pool', 'value' => 'Pool'],
            ['key' => 'Spa', 'value' => 'Spa'],
            ['key' => 'Strand', 'value' => 'Strand'],
            ['key' => 'Bar', 'value' => 'Bar'],
            ['key' => 'Kultur', 'value' => 'Kultur'],
            ['key' => 'Ski', 'value' => 'Ski'],
            ['key' => 'Fitness', 'value' => 'Fitness'],
            ['key' => 'Business', 'value' => 'Business'],
            ['key' => 'Meerblick', 'value' => 'Meerblick'],
            ['key' => 'Romantik', 'value' => 'Romantik'],
            ['key' => 'Haustiere erlaubt', 'value' => 'Haustiere erlaubt'],
            ['key' => 'Klimaanlage', 'value' => 'Klimaanlage'],
            ['key' => '24h Rezeption', 'value' => '24h Rezeption'],
            ['key' => 'Concierge', 'value' => 'Concierge'],
            ['key' => 'Shuttle Service', 'value' => 'Shuttle Service'],
            ['key' => 'Kinderbetreuung', 'value' => 'Kinderbetreuung'],
            ['key' => 'Wäscheservice', 'value' => 'Wäscheservice']
        ]);
        
        $featuresPanel->setChildren([
            $featuredField,
            $amenitiesField
        ]);
        
        $layout->setChildren([
            $basicPanel,
            $ratingsPanel,
            $pricingPanel,
            $featuresPanel
        ]);
        
        $class->setLayoutDefinitions($layout);
        $class->save();
        
        echo "Hotel class created successfully!\n";
    } catch (\Exception $e) {
        echo "Error creating Hotel class: " . $e->getMessage() . "\n";
    }
}

function createRestaurantClass() {
    try {
        // Check if class already exists
        $existingClass = ClassDefinition::getByName('Restaurant');
        if ($existingClass) {
            echo "Restaurant class already exists, skipping...\n";
            return;
        }

        $class = new ClassDefinition();
        $class->setName('Restaurant');
        $class->setUserOwner(1);
        $class->setUserModification(1);
        $class->setParentClass('');
        $class->setAllowInherit(false);
        $class->setAllowVariants(false);
        $class->setShowVariants(false);
        $class->setIcon('/bundles/pimcoreadmin/img/flat-color-icons/restaurant.svg');
        $class->setGroup('Travel');

        // Create layout
        $layout = new Layout\Panel();
        $layout->setName('Layout');
        $layout->setTitle('Layout');
        
        // Basic Information Panel
        $basicPanel = new Layout\Panel();
        $basicPanel->setName('Basic Information');
        $basicPanel->setTitle('Basic Information');
        
        // Name field
        $nameField = new Data\Input();
        $nameField->setName('name');
        $nameField->setTitle('Restaurant Name');
        $nameField->setMandatory(true);
        $nameField->setVisibleGridView(true);
        $nameField->setVisibleSearch(true);
        
        // Cuisine field
        $cuisineField = new Data\Select();
        $cuisineField->setName('cuisine');
        $cuisineField->setTitle('Cuisine Type');
        $cuisineField->setMandatory(true);
        $cuisineField->setVisibleGridView(true);
        $cuisineField->setVisibleSearch(true);
        $cuisineField->setOptions([
            ['key' => 'Italienisch', 'value' => 'Italienisch'],
            ['key' => 'Japanisch', 'value' => 'Japanisch'],
            ['key' => 'Französisch', 'value' => 'Französisch'],
            ['key' => 'Indisch', 'value' => 'Indisch'],
            ['key' => 'Spanisch', 'value' => 'Spanisch'],
            ['key' => 'Thailändisch', 'value' => 'Thailändisch'],
            ['key' => 'Chinesisch', 'value' => 'Chinesisch'],
            ['key' => 'Mexikanisch', 'value' => 'Mexikanisch'],
            ['key' => 'Deutsch', 'value' => 'Deutsch'],
            ['key' => 'Griechisch', 'value' => 'Griechisch'],
            ['key' => 'Türkisch', 'value' => 'Türkisch'],
            ['key' => 'Amerikanisch', 'value' => 'Amerikanisch'],
            ['key' => 'Mediterran', 'value' => 'Mediterran'],
            ['key' => 'Asiatisch', 'value' => 'Asiatisch'],
            ['key' => 'International', 'value' => 'International']
        ]);
        
        // Location field
        $locationField = new Data\Input();
        $locationField->setName('location');
        $locationField->setTitle('Location');
        $locationField->setMandatory(true);
        $locationField->setVisibleGridView(true);
        $locationField->setVisibleSearch(true);
        
        // Description field
        $descriptionField = new Data\Textarea();
        $descriptionField->setName('description');
        $descriptionField->setTitle('Description');
        
        // Image field
        $imageField = new Data\Image();
        $imageField->setName('image');
        $imageField->setTitle('Restaurant Image');
        
        $basicPanel->setChildren([
            $nameField,
            $cuisineField,
            $locationField,
            $descriptionField,
            $imageField
        ]);
        
        // Ratings & Reviews Panel
        $ratingsPanel = new Layout\Panel();
        $ratingsPanel->setName('Ratings & Reviews');
        $ratingsPanel->setTitle('Ratings & Reviews');
        
        // Rating field
        $ratingField = new Data\Numeric();
        $ratingField->setName('rating');
        $ratingField->setTitle('Rating');
        $ratingField->setMinValue(0);
        $ratingField->setMaxValue(5);
        $ratingField->setDecimalPrecision(1);
        $ratingField->setVisibleGridView(true);
        $ratingField->setVisibleSearch(true);
        
        // Review Count field
        $reviewCountField = new Data\Numeric();
        $reviewCountField->setName('reviewCount');
        $reviewCountField->setTitle('Review Count');
        $reviewCountField->setInteger(true);
        $reviewCountField->setMinValue(0);
        $reviewCountField->setDefaultValue(0);
        $reviewCountField->setVisibleGridView(true);
        $reviewCountField->setVisibleSearch(true);
        
        $ratingsPanel->setChildren([
            $ratingField,
            $reviewCountField
        ]);
        
        // Pricing & Hours Panel
        $pricingPanel = new Layout\Panel();
        $pricingPanel->setName('Pricing & Hours');
        $pricingPanel->setTitle('Pricing & Hours');
        
        // Price Range field
        $priceRangeField = new Data\Select();
        $priceRangeField->setName('priceRange');
        $priceRangeField->setTitle('Price Range');
        $priceRangeField->setVisibleGridView(true);
        $priceRangeField->setVisibleSearch(true);
        $priceRangeField->setOptions([
            ['key' => '€', 'value' => '€ (Günstig)'],
            ['key' => '€€', 'value' => '€€ (Mittel)'],
            ['key' => '€€€', 'value' => '€€€ (Gehoben)'],
            ['key' => '€€€€', 'value' => '€€€€ (Luxus)']
        ]);
        
        // Opening Hours field
        $openingHoursField = new Data\Input();
        $openingHoursField->setName('openingHours');
        $openingHoursField->setTitle('Opening Hours');
        $openingHoursField->setVisibleGridView(true);
        
        $pricingPanel->setChildren([
            $priceRangeField,
            $openingHoursField
        ]);
        
        // Features Panel
        $featuresPanel = new Layout\Panel();
        $featuresPanel->setName('Features');
        $featuresPanel->setTitle('Features');
        
        // Featured field
        $featuredField = new Data\Checkbox();
        $featuredField->setName('featured');
        $featuredField->setTitle('Featured Restaurant');
        $featuredField->setDefaultValue(false);
        $featuredField->setVisibleGridView(true);
        $featuredField->setVisibleSearch(true);
        
        $featuresPanel->setChildren([
            $featuredField
        ]);
        
        $layout->setChildren([
            $basicPanel,
            $ratingsPanel,
            $pricingPanel,
            $featuresPanel
        ]);
        
        $class->setLayoutDefinitions($layout);
        $class->save();
        
        echo "Restaurant class created successfully!\n";
    } catch (\Exception $e) {
        echo "Error creating Restaurant class: " . $e->getMessage() . "\n";
    }
}

// Execute the functions
echo "Creating Pimcore Classes...\n";
echo "========================\n\n";

createDestinationClass();
createHotelClass();
createRestaurantClass();

echo "\n========================\n";
echo "Class creation completed!\n";