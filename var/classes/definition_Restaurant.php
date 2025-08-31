<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - restaurantId [input]
 * - name [input]
 * - cuisine [select]
 * - description [textarea]
 * - atmosphere [input]
 * - location [input]
 * - address [input]
 * - phone [input]
 * - website [input]
 * - openingHours [input]
 * - rating [numeric]
 * - reviewCount [numeric]
 * - priceRange [select]
 * - seatingCapacity [numeric]
 * - images [imageGallery]
 * - features [multiselect]
 * - specialties [multiselect]
 */

return \Pimcore\Model\DataObject\ClassDefinition::__set_state(array(
   'dao' => NULL,
   'id' => '4',
   'name' => 'Restaurant',
   'title' => '',
   'description' => '',
   'creationDate' => NULL,
   'modificationDate' => 1756655751,
   'userOwner' => 2,
   'userModification' => 2,
   'parentClass' => '',
   'implementsInterfaces' => '',
   'listingParentClass' => '',
   'useTraits' => '',
   'listingUseTraits' => '',
   'encryption' => false,
   'encryptedTables' => 
  array (
  ),
   'allowInherit' => false,
   'allowVariants' => false,
   'showVariants' => false,
   'layoutDefinitions' => 
  \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
     'name' => 'pimcore_root',
     'type' => NULL,
     'region' => NULL,
     'title' => NULL,
     'width' => 0,
     'height' => 0,
     'collapsible' => false,
     'collapsed' => false,
     'bodyStyle' => NULL,
     'datatype' => 'layout',
     'children' => 
    array (
      0 => 
      \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
         'name' => 'Layout',
         'type' => NULL,
         'region' => NULL,
         'title' => 'Basis-Informationen',
         'width' => '',
         'height' => '',
         'collapsible' => false,
         'collapsed' => false,
         'bodyStyle' => '',
         'datatype' => 'layout',
         'children' => 
        array (
          0 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
             'name' => 'restaurantId',
             'title' => 'Restaurant ID',
             'tooltip' => 'Eindeutige ID des Restaurants',
             'mandatory' => true,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => true,
             'visibleSearch' => true,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'columnLength' => 190,
             'regex' => '',
             'regexFlags' => 
            array (
            ),
             'unique' => true,
             'showCharCount' => false,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          1 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
             'name' => 'name',
             'title' => 'Restaurant Name',
             'tooltip' => 'Name des Restaurants',
             'mandatory' => true,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => true,
             'visibleSearch' => true,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'columnLength' => 255,
             'regex' => '',
             'regexFlags' => 
            array (
            ),
             'unique' => false,
             'showCharCount' => false,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          2 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Select::__set_state(array(
             'name' => 'cuisine',
             'title' => 'Küche',
             'tooltip' => 'Art der Küche',
             'mandatory' => true,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => true,
             'visibleSearch' => true,
             'blockedVarsForExport' => 
            array (
            ),
             'options' => 
            array (
              0 => 
              array (
                'key' => 'Italienisch',
                'value' => 'Italienisch',
              ),
              1 => 
              array (
                'key' => 'Französisch',
                'value' => 'Französisch',
              ),
              2 => 
              array (
                'key' => 'Deutsch',
                'value' => 'Deutsch',
              ),
              3 => 
              array (
                'key' => 'Asiatisch',
                'value' => 'Asiatisch',
              ),
              4 => 
              array (
                'key' => 'Japanisch',
                'value' => 'Japanisch',
              ),
              5 => 
              array (
                'key' => 'Chinesisch',
                'value' => 'Chinesisch',
              ),
              6 => 
              array (
                'key' => 'Indisch',
                'value' => 'Indisch',
              ),
              7 => 
              array (
                'key' => 'Mexikanisch',
                'value' => 'Mexikanisch',
              ),
              8 => 
              array (
                'key' => 'Spanisch',
                'value' => 'Spanisch',
              ),
              9 => 
              array (
                'key' => 'Griechisch',
                'value' => 'Griechisch',
              ),
              10 => 
              array (
                'key' => 'Türkisch',
                'value' => 'Türkisch',
              ),
              11 => 
              array (
                'key' => 'International',
                'value' => 'International',
              ),
              12 => 
              array (
                'key' => 'Vegetarisch/Vegan',
                'value' => 'Vegetarisch/Vegan',
              ),
              13 => 
              array (
                'key' => 'Seafood',
                'value' => 'Seafood',
              ),
              14 => 
              array (
                'key' => 'Steakhouse',
                'value' => 'Steakhouse',
              ),
            ),
             'defaultValue' => '',
             'columnLength' => 190,
             'dynamicOptions' => false,
             'defaultValueGenerator' => '',
             'width' => '',
             'optionsProviderType' => NULL,
             'optionsProviderClass' => '',
             'optionsProviderData' => '',
          )),
          3 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Textarea::__set_state(array(
             'name' => 'description',
             'title' => 'Beschreibung',
             'tooltip' => 'Detaillierte Beschreibung des Restaurants',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => false,
             'visibleSearch' => true,
             'blockedVarsForExport' => 
            array (
            ),
             'maxLength' => NULL,
             'showCharCount' => false,
             'excludeFromSearchIndex' => false,
             'height' => 200,
             'width' => '',
          )),
          4 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
             'name' => 'atmosphere',
             'title' => 'Atmosphäre',
             'tooltip' => 'Beschreibung der Atmosphäre',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => false,
             'visibleSearch' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'columnLength' => 255,
             'regex' => '',
             'regexFlags' => 
            array (
            ),
             'unique' => false,
             'showCharCount' => false,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          5 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
             'name' => 'location',
             'title' => 'Standort',
             'tooltip' => 'Stadt und Stadtteil',
             'mandatory' => true,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => true,
             'visibleSearch' => true,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'columnLength' => 255,
             'regex' => '',
             'regexFlags' => 
            array (
            ),
             'unique' => false,
             'showCharCount' => false,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          6 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
             'name' => 'address',
             'title' => 'Adresse',
             'tooltip' => 'Vollständige Adresse',
             'mandatory' => true,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => false,
             'visibleSearch' => true,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'columnLength' => 255,
             'regex' => '',
             'regexFlags' => 
            array (
            ),
             'unique' => false,
             'showCharCount' => false,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          7 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
             'name' => 'phone',
             'title' => 'Telefonnummer',
             'tooltip' => 'Kontakt-Telefonnummer',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => false,
             'visibleSearch' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'columnLength' => 100,
             'regex' => '',
             'regexFlags' => 
            array (
            ),
             'unique' => false,
             'showCharCount' => false,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          8 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
             'name' => 'website',
             'title' => 'Website',
             'tooltip' => 'Website des Restaurants',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => false,
             'visibleSearch' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'columnLength' => 255,
             'regex' => '',
             'regexFlags' => 
            array (
            ),
             'unique' => false,
             'showCharCount' => false,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          9 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
             'name' => 'openingHours',
             'title' => 'Öffnungszeiten',
             'tooltip' => 'Öffnungszeiten des Restaurants',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => true,
             'visibleSearch' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'columnLength' => 100,
             'regex' => '',
             'regexFlags' => 
            array (
            ),
             'unique' => false,
             'showCharCount' => false,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          10 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric::__set_state(array(
             'name' => 'rating',
             'title' => 'Bewertung',
             'tooltip' => 'Durchschnittliche Bewertung (0-5)',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => true,
             'visibleSearch' => true,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'integer' => false,
             'unsigned' => false,
             'minValue' => 0.0,
             'maxValue' => 5.0,
             'unique' => false,
             'decimalSize' => 1,
             'decimalPrecision' => 1,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          11 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric::__set_state(array(
             'name' => 'reviewCount',
             'title' => 'Anzahl Bewertungen',
             'tooltip' => 'Gesamtanzahl der Bewertungen',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => true,
             'visibleSearch' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => 0,
             'integer' => true,
             'unsigned' => true,
             'minValue' => 0.0,
             'maxValue' => NULL,
             'unique' => false,
             'decimalSize' => NULL,
             'decimalPrecision' => NULL,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          12 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Select::__set_state(array(
             'name' => 'priceRange',
             'title' => 'Preiskategorie',
             'tooltip' => 'Preiskategorie des Restaurants',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => true,
             'visibleSearch' => true,
             'blockedVarsForExport' => 
            array (
            ),
             'options' => 
            array (
              0 => 
              array (
                'key' => '€',
                'value' => '€',
              ),
              1 => 
              array (
                'key' => '€€',
                'value' => '€€',
              ),
              2 => 
              array (
                'key' => '€€€',
                'value' => '€€€',
              ),
              3 => 
              array (
                'key' => '€€€€',
                'value' => '€€€€',
              ),
            ),
             'defaultValue' => '',
             'columnLength' => 190,
             'dynamicOptions' => false,
             'defaultValueGenerator' => '',
             'width' => '',
             'optionsProviderType' => NULL,
             'optionsProviderClass' => '',
             'optionsProviderData' => '',
          )),
          13 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric::__set_state(array(
             'name' => 'seatingCapacity',
             'title' => 'Sitzplätze',
             'tooltip' => 'Anzahl der Sitzplätze',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => false,
             'visibleSearch' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'defaultValue' => NULL,
             'integer' => true,
             'unsigned' => true,
             'minValue' => 0.0,
             'maxValue' => NULL,
             'unique' => false,
             'decimalSize' => NULL,
             'decimalPrecision' => NULL,
             'width' => '',
             'defaultValueGenerator' => '',
          )),
          14 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\ImageGallery::__set_state(array(
             'name' => 'images',
             'title' => 'Bildergalerie',
             'tooltip' => 'Bilder des Restaurants',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => false,
             'visibleSearch' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'uploadPath' => '',
             'ratioX' => NULL,
             'ratioY' => NULL,
             'predefinedDataTemplates' => '',
             'height' => 500,
             'width' => 500,
          )),
          15 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Multiselect::__set_state(array(
             'name' => 'features',
             'title' => 'Features',
             'tooltip' => 'Verfügbare Features und Services',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => false,
             'visibleSearch' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'options' => 
            array (
              0 => 
              array (
                'key' => 'WLAN',
                'value' => 'WLAN',
              ),
              1 => 
              array (
                'key' => 'Parkplatz',
                'value' => 'Parkplatz',
              ),
              2 => 
              array (
                'key' => 'Kartenzahlung',
                'value' => 'Kartenzahlung',
              ),
              3 => 
              array (
                'key' => 'Reservierung',
                'value' => 'Reservierung',
              ),
              4 => 
              array (
                'key' => 'Terrasse',
                'value' => 'Terrasse',
              ),
              5 => 
              array (
                'key' => 'Garten',
                'value' => 'Garten',
              ),
              6 => 
              array (
                'key' => 'Klimaanlage',
                'value' => 'Klimaanlage',
              ),
              7 => 
              array (
                'key' => 'Barrierefrei',
                'value' => 'Barrierefrei',
              ),
              8 => 
              array (
                'key' => 'Kinderfreundlich',
                'value' => 'Kinderfreundlich',
              ),
              9 => 
              array (
                'key' => 'Haustiere erlaubt',
                'value' => 'Haustiere erlaubt',
              ),
              10 => 
              array (
                'key' => 'Live-Musik',
                'value' => 'Live-Musik',
              ),
              11 => 
              array (
                'key' => 'Private Räume',
                'value' => 'Private Räume',
              ),
              12 => 
              array (
                'key' => 'Catering',
                'value' => 'Catering',
              ),
              13 => 
              array (
                'key' => 'Lieferservice',
                'value' => 'Lieferservice',
              ),
              14 => 
              array (
                'key' => 'Take-Away',
                'value' => 'Take-Away',
              ),
              15 => 
              array (
                'key' => 'Vegetarische Optionen',
                'value' => 'Vegetarische Optionen',
              ),
              16 => 
              array (
                'key' => 'Vegane Optionen',
                'value' => 'Vegane Optionen',
              ),
              17 => 
              array (
                'key' => 'Glutenfreie Optionen',
                'value' => 'Glutenfreie Optionen',
              ),
            ),
             'maxItems' => NULL,
             'renderType' => 'list',
             'dynamicOptions' => false,
             'defaultValue' => NULL,
             'height' => 300,
             'width' => '',
             'defaultValueGenerator' => '',
             'optionsProviderType' => NULL,
             'optionsProviderClass' => '',
             'optionsProviderData' => '',
          )),
          16 => 
          \Pimcore\Model\DataObject\ClassDefinition\Data\Multiselect::__set_state(array(
             'name' => 'specialties',
             'title' => 'Spezialitäten',
             'tooltip' => 'Spezialitäten des Hauses',
             'mandatory' => false,
             'noteditable' => false,
             'index' => false,
             'locked' => false,
             'style' => '',
             'permissions' => NULL,
             'fieldtype' => '',
             'relationType' => false,
             'invisible' => false,
             'visibleGridView' => false,
             'visibleSearch' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'options' => 
            array (
              0 => 
              array (
                'key' => 'Hausgemachte Pasta',
                'value' => 'Hausgemachte Pasta',
              ),
              1 => 
              array (
                'key' => 'Pizza aus dem Steinofen',
                'value' => 'Pizza aus dem Steinofen',
              ),
              2 => 
              array (
                'key' => 'Frische Meeresfrüchte',
                'value' => 'Frische Meeresfrüchte',
              ),
              3 => 
              array (
                'key' => 'Tiramisu',
                'value' => 'Tiramisu',
              ),
              4 => 
              array (
                'key' => 'Gegrilltes Fleisch',
                'value' => 'Gegrilltes Fleisch',
              ),
              5 => 
              array (
                'key' => 'Sushi',
                'value' => 'Sushi',
              ),
              6 => 
              array (
                'key' => 'Tapas',
                'value' => 'Tapas',
              ),
              7 => 
              array (
                'key' => 'Wein-Auswahl',
                'value' => 'Wein-Auswahl',
              ),
              8 => 
              array (
                'key' => 'Craft Beer',
                'value' => 'Craft Beer',
              ),
              9 => 
              array (
                'key' => 'Cocktails',
                'value' => 'Cocktails',
              ),
              10 => 
              array (
                'key' => 'Brunch',
                'value' => 'Brunch',
              ),
              11 => 
              array (
                'key' => 'Frühstück',
                'value' => 'Frühstück',
              ),
              12 => 
              array (
                'key' => 'Desserts',
                'value' => 'Desserts',
              ),
              13 => 
              array (
                'key' => 'Tagesmenü',
                'value' => 'Tagesmenü',
              ),
              14 => 
              array (
                'key' => 'Saisonale Gerichte',
                'value' => 'Saisonale Gerichte',
              ),
            ),
             'maxItems' => NULL,
             'renderType' => 'list',
             'dynamicOptions' => false,
             'defaultValue' => NULL,
             'height' => 250,
             'width' => '',
             'defaultValueGenerator' => '',
             'optionsProviderType' => NULL,
             'optionsProviderClass' => '',
             'optionsProviderData' => '',
          )),
        ),
         'locked' => false,
         'blockedVarsForExport' => 
        array (
        ),
         'fieldtype' => 'panel',
         'layout' => NULL,
         'border' => false,
         'icon' => '',
         'labelWidth' => 100,
         'labelAlign' => 'left',
      )),
    ),
     'locked' => false,
     'blockedVarsForExport' => 
    array (
    ),
     'fieldtype' => 'panel',
     'layout' => NULL,
     'border' => false,
     'icon' => NULL,
     'labelWidth' => 100,
     'labelAlign' => 'left',
  )),
   'icon' => '',
   'group' => '',
   'showAppLoggerTab' => false,
   'linkGeneratorReference' => '',
   'previewGeneratorReference' => '',
   'compositeIndices' => 
  array (
  ),
   'showFieldLookup' => false,
   'propertyVisibility' => 
  array (
    'grid' => 
    array (
      'id' => true,
      'key' => false,
      'path' => true,
      'published' => true,
      'modificationDate' => true,
      'creationDate' => true,
    ),
    'search' => 
    array (
      'id' => true,
      'key' => false,
      'path' => true,
      'published' => true,
      'modificationDate' => true,
      'creationDate' => true,
    ),
  ),
   'enableGridLocking' => false,
   'deletedDataComponents' => 
  array (
  ),
   'blockedVarsForExport' => 
  array (
  ),
   'fieldDefinitionsCache' => 
  array (
  ),
   'activeDispatchingEvents' => 
  array (
  ),
));
