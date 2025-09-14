<?php

namespace App\Command;

use Pimcore\Console\AbstractCommand;
use Pimcore\Model\Document;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateHotelsPageCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-hotels-page')
            ->setDescription('Create or update hotels page in Pimcore');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Checking for hotels page...</info>');

        // Check if hotels page exists
        $hotelsPage = Document::getByPath('/hotels');

        if (!$hotelsPage) {
            $output->writeln('Hotels page not found. Creating new page...');

            // Get parent (home)
            $home = Document::getById(1);
            if (!$home) {
                $output->writeln('<error>Home document not found!</error>');
                return self::FAILURE;
            }

            // Create hotels page
            $hotelsPage = new Document\Page();
            $hotelsPage->setParent($home);
            $hotelsPage->setKey('hotels');
            $hotelsPage->setPublished(true);
        } else {
            $output->writeln('Hotels page found. Updating...');
        }

        // Set controller and action
        $hotelsPage->setController('App\Controller\HotelsController');
        $hotelsPage->setAction('default');
        $hotelsPage->setTitle('Hotels');
        $hotelsPage->setDescription('Browse our hotel collection');
        $hotelsPage->setProperty('navigation_name', 'text', 'Hotels');

        try {
            $hotelsPage->save();
            $output->writeln('<info>Hotels page saved successfully!</info>');
            $output->writeln('Path: ' . $hotelsPage->getFullPath());
            $output->writeln('Controller: ' . $hotelsPage->getController());
            $output->writeln('Action: ' . $hotelsPage->getAction());
        } catch (\Exception $e) {
            $output->writeln('<error>Error saving hotels page: ' . $e->getMessage() . '</error>');
            return self::FAILURE;
        }

        // Check for existing pages and list them
        $output->writeln("\n<info>Listing all pages:</info>");
        $listing = new Document\Listing();
        $listing->setCondition("type = 'page'");
        $listing->setOrderKey("path");
        $listing->setOrder("ASC");

        foreach ($listing as $doc) {
            $output->writeln('- ' . $doc->getFullPath());
            if ($doc instanceof Document\Page) {
                $output->writeln('  Controller: ' . ($doc->getController() ?: 'none'));
                $output->writeln('  Action: ' . ($doc->getAction() ?: 'none'));
            }
        }

        return self::SUCCESS;
    }
}