<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace App\Controller;

use App\Form\CarSubmitFormType;
use App\Model\Product\Car;
use App\Website\Tool\Text;
use Pimcore\Bundle\EcommerceFrameworkBundle\Factory;
use Pimcore\Controller\Attribute\ResponseHeader;
use Pimcore\Model\DataObject\BodyStyle;
use Pimcore\Model\DataObject\Hotel;
use Pimcore\Model\DataObject\Manufacturer;
use Pimcore\Model\DataObject\Service;
use Pimcore\Translation\Translator;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentController
{
    #[Template('content/default.html.twig')]
    public function defaultAction(): array
    {
        return [];
    }

    #[Template('content/hotels.html.twig')]
    public function hotelsAction(): array
    {
        // Get all published hotels
        $hotelsList = new Hotel\Listing();
        $hotelsList->setCondition('published = 1');
        $hotels = $hotelsList->load();

        // If no published hotels, get all for debugging
        if (empty($hotels)) {
            $allHotelsList = new Hotel\Listing();
            $hotels = $allHotelsList->load();
        }

        // Separate featured hotels
        $featuredHotels = [];
        $regularHotels = [];

        foreach ($hotels as $hotel) {
            if ($hotel && $hotel->getFeatured()) {
                $featuredHotels[] = $hotel;
            } else {
                $regularHotels[] = $hotel;
            }
        }

        return [
            'featuredHotels' => $featuredHotels,
            'regularHotels' => $regularHotels,
            'allHotels' => $hotels,
            'totalCount' => count($hotels)
        ];
    }

}
