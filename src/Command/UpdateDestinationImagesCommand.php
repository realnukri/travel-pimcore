<?php

namespace App\Command;

use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pimcore\Model\DataObject\Destionation;
use Pimcore\Model\Asset;

class UpdateDestinationImagesCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('app:update-destination-images')
            ->setDescription('Update images for existing destinations');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Image mapping
        $imageMapping = [
            'Malediven' => 'maldives-1.jpg',
            'Schweizer Alpen' => 'swiss-alps-1.jpg',
            'Prag' => 'prague-1.jpg',
            'Paris' => 'paris-1.jpg',
            'Tokio' => 'tokyo.jpg',
            'New York City' => 'new-york.jpg',
            'Dubai' => 'dubai.jpg',
            'Bali' => 'bali.jpg',
            'Rom' => 'rome.jpg',
            'Santorini' => 'santorini.jpg',
            'London' => 'london.jpg',
            'Barcelona' => 'barcelona.jpg',
            'Istanbul' => 'istanbul.jpg',
            'Sydney' => 'sydney.jpg',
            'Amsterdam' => 'amsterdam.jpg',
            'Wien' => 'vienna.jpg',
            'Singapur' => 'singapore.jpg',
            'Lissabon' => 'city-historic.jpg',
            'Kairo' => 'city-historic.jpg',
            'Bangkok' => 'hero-beach.jpg',
            'Kyoto' => 'mountains.jpg',
            'Edinburgh' => 'mountains.jpg',
            'Reykjavik' => 'mountains.jpg',
            'Oslo' => 'mountains.jpg',
            'Zürich' => 'mountains.jpg',
            'Genf' => 'mountains.jpg',
            'Valencia' => 'hero-beach.jpg',
            'Nizza' => 'hero-beach.jpg'
        ];

        try {
            // Create or get the Destinations folder in Assets
            $assetParentFolder = Asset\Service::createFolderByPath('/Destinations');
            $output->writeln('<info>Assets folder ready: /Destinations</info>');

            // Source path for images (inside container)
            $sourceImagePath = '/var/www/html/public/var/assets/temp_import/';
            $processedImages = [];

            // First, upload all images
            foreach ($imageMapping as $destName => $imageName) {
                // Check if asset already exists
                $assetPath = '/Destinations/' . $imageName;
                $existingAsset = Asset::getByPath($assetPath);
                
                if (!$existingAsset) {
                    $sourceFile = $sourceImagePath . $imageName;
                    if (file_exists($sourceFile)) {
                        $asset = new Asset\Image();
                        $asset->setFilename($imageName);
                        $asset->setData(file_get_contents($sourceFile));
                        $asset->setParent($assetParentFolder);
                        $asset->save();
                        $output->writeln('<comment>Uploaded image: ' . $imageName . '</comment>');
                        $processedImages[$imageName] = $asset;
                    } else {
                        $output->writeln('<error>Image not found: ' . $sourceFile . '</error>');
                    }
                } else {
                    $processedImages[$imageName] = $existingAsset;
                    $output->writeln('Image already exists: ' . $imageName);
                }
            }

            // Now update all destinations with their images
            $destinationList = new Destionation\Listing();
            $destinations = $destinationList->load();

            foreach ($destinations as $destination) {
                $name = $destination->getName();
                if (isset($imageMapping[$name]) && isset($processedImages[$imageMapping[$name]])) {
                    $destination->setImage($processedImages[$imageMapping[$name]]);
                    $destination->save();
                    $output->writeln('<info>Updated image for: ' . $name . '</info>');
                } else {
                    $output->writeln('<comment>No image mapping for: ' . $name . '</comment>');
                }
            }

            $output->writeln('');
            $output->writeln('<info>✅ Image update completed successfully!</info>');

            return self::SUCCESS;

        } catch (\Exception $e) {
            $output->writeln('<error>Error: ' . $e->getMessage() . '</error>');
            $output->writeln($e->getTraceAsString());
            return self::FAILURE;
        }
    }
}