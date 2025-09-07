<?php

namespace App\Command;

use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pimcore\Model\Asset\Image\Thumbnail\Config;

class CreateThumbnailConfigCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('app:create-thumbnail-configs')
            ->setDescription('Create thumbnail configurations for destinations');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            // Create "content" thumbnail configuration
            $contentConfig = Config::getByName('content');
            if (!$contentConfig) {
                $contentConfig = new Config();
                $contentConfig->setName('content');
                $contentConfig->setDescription('Content images for destination cards');
                $contentConfig->setFormat('JPEG');
                $contentConfig->setQuality(85);
                $contentConfig->setHighResolution(2.0);
                $contentConfig->setItems([
                    [
                        'method' => 'cover',
                        'arguments' => [
                            'width' => 400,
                            'height' => 250,
                            'positioning' => 'center',
                            'forceResize' => false
                        ]
                    ]
                ]);
                $contentConfig->save();
                $output->writeln('<info>Created thumbnail config: content</info>');
            } else {
                $output->writeln('Thumbnail config "content" already exists');
            }

            // Create "card" thumbnail configuration
            $cardConfig = Config::getByName('card');
            if (!$cardConfig) {
                $cardConfig = new Config();
                $cardConfig->setName('card');
                $cardConfig->setDescription('Card images for destination grid');
                $cardConfig->setFormat('JPEG');
                $cardConfig->setQuality(85);
                $cardConfig->setItems([
                    [
                        'method' => 'cover',
                        'arguments' => [
                            'width' => 600,
                            'height' => 400,
                            'positioning' => 'center',
                            'forceResize' => false
                        ]
                    ]
                ]);
                $cardConfig->save();
                $output->writeln('<info>Created thumbnail config: card</info>');
            } else {
                $output->writeln('Thumbnail config "card" already exists');
            }

            // Create "preview" thumbnail configuration
            $previewConfig = Config::getByName('preview');
            if (!$previewConfig) {
                $previewConfig = new Config();
                $previewConfig->setName('preview');
                $previewConfig->setDescription('Preview images');
                $previewConfig->setFormat('JPEG');
                $previewConfig->setQuality(75);
                $previewConfig->setItems([
                    [
                        'method' => 'scaleByWidth',
                        'arguments' => [
                            'width' => 800,
                            'forceResize' => false
                        ]
                    ]
                ]);
                $previewConfig->save();
                $output->writeln('<info>Created thumbnail config: preview</info>');
            } else {
                $output->writeln('Thumbnail config "preview" already exists');
            }

            $output->writeln('<info>✅ Thumbnail configurations created successfully!</info>');

            return self::SUCCESS;

        } catch (\Exception $e) {
            $output->writeln('<error>Error: ' . $e->getMessage() . '</error>');
            return self::FAILURE;
        }
    }
}