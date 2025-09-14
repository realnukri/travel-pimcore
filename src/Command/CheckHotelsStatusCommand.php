<?php

namespace App\Command;

use Pimcore\Console\AbstractCommand;
use Pimcore\Model\DataObject\Hotel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckHotelsStatusCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('app:check-hotels-status')
            ->setDescription('Check the status of all hotels in the system');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Checking hotels status...</info>');

        // Get ALL hotels
        $allHotelsList = new Hotel\Listing();
        $allHotels = $allHotelsList->load();

        $output->writeln('Total hotels in system: ' . count($allHotels));

        // Get published hotels
        $publishedList = new Hotel\Listing();
        $publishedList->setCondition('published = 1');
        $publishedHotels = $publishedList->load();

        $output->writeln('Published hotels: ' . count($publishedHotels));
        $output->writeln('');

        // List first 10 hotels with details
        $output->writeln('<info>First 10 hotels details:</info>');
        $count = 0;
        foreach ($allHotels as $hotel) {
            if ($count >= 10) break;

            $output->writeln(sprintf(
                '- %s (ID: %d, Published: %s, Featured: %s, Location: %s, Price: €%s)',
                $hotel->getName('de') ?: $hotel->getKey(),
                $hotel->getId(),
                $hotel->getPublished() ? 'Yes' : 'No',
                $hotel->getFeatured() ? 'Yes' : 'No',
                $hotel->getLocation() ?: 'N/A',
                $hotel->getPrice() ?: '0'
            ));
            $count++;
        }

        return self::SUCCESS;
    }
}