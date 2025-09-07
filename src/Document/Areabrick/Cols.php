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

namespace App\Document\Areabrick;

use Pimcore\Model\Document\Editable\Area\Info;
use Symfony\Component\HttpFoundation\Response;

class Cols extends AbstractAreabrick
{
    public function getName(): string
    {
        return 'Spalten Layout';
    }
    
    public function getDescription(): string
    {
        return 'Flexibles Spaltenlayout mit responsiven Einstellungen für verschiedene Bildschirmgrößen';
    }
    
    public function action(Info $info): ?Response
    {
        // Set default values if not set
        $cols = $info->getEditable('cols');
        if (!$cols || !$cols->getData()) {
            $cols->setDataFromResource(2); // Default to 2 columns
        }
        
        return null;
    }
}
