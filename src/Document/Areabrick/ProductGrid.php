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

class ProductGrid extends AbstractAreabrick
{
    public function getName(): string
    {
        return 'Destination Grid';
    }
    
    public function getDescription(): string
    {
        return 'Zeigt eine Auswahl von Reisezielen in einem Grid-Layout an';
    }
    
    public function action(Info $info): ?Response
    {
        // Optional: Add any preprocessing logic here if needed
        return null;
    }
}
