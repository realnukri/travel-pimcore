<?php

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;

class Slider extends AbstractTemplateAreabrick
{
    public function getName(): string
    {
        return 'Image Slider';
    }

    public function getDescription(): string
    {
        return 'Ein responsiver Bilder-Slider mit Navigation und Dots';
    }

    public function getIcon(): ?string
    {
        return '/bundles/pimcoreadmin/img/flat-color-icons/gallery.svg';
    }

    public function needsReload(): bool
    {
        return false;
    }
}