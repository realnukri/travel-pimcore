<?php

use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Service;

// Bootstrap Pimcore
$pimcorePath = __DIR__ . '/vendor/autoload.php';
require_once $pimcorePath;

\Pimcore\Bootstrap::setProjectRoot();
\Pimcore\Bootstrap::bootstrap();

function importClassFromJson($jsonFile, $className) {
    try {
        if (!file_exists($jsonFile)) {
            echo "File not found: $jsonFile\n";
            return false;
        }
        
        $jsonContent = file_get_contents($jsonFile);
        $definition = json_decode($jsonContent, true);
        
        if (!$definition) {
            echo "Invalid JSON in file: $jsonFile\n";
            return false;
        }
        
        // Check if class already exists
        $existingClass = ClassDefinition::getByName($className);
        if ($existingClass) {
            echo "Class $className already exists. Updating...\n";
            $class = $existingClass;
        } else {
            echo "Creating new class: $className\n";
            $class = new ClassDefinition();
            $class->setName($className);
        }
        
        // Set basic properties
        $class->setUserOwner(1);
        $class->setUserModification(1);
        $class->setGroup('Travel');
        
        // Import the definition
        Service::importClassDefinitionFromJson($class, $jsonContent, true);
        
        echo "Class $className imported successfully!\n";
        return true;
        
    } catch (\Exception $e) {
        echo "Error importing $className: " . $e->getMessage() . "\n";
        return false;
    }
}

// Main execution
echo "Importing Pimcore Classes from JSON files...\n";
echo "===========================================\n\n";

$classesToImport = [
    ['file' => 'pimcore-classes/class_Destination_export.json', 'name' => 'Destination'],
    ['file' => 'pimcore-classes/definition_Flight.json', 'name' => 'Flight'],
    ['file' => 'pimcore-classes/definition_Hotel.json', 'name' => 'Hotel'],
    ['file' => 'pimcore-classes/definition_Restaurant.json', 'name' => 'Restaurant']
];

$successCount = 0;
foreach ($classesToImport as $classInfo) {
    if (importClassFromJson($classInfo['file'], $classInfo['name'])) {
        $successCount++;
    }
    echo "\n";
}

echo "===========================================\n";
echo "Import completed! $successCount/" . count($classesToImport) . " classes imported successfully.\n";