<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\RuntimeExtensionInterface;

class AppAssetUploads implements RuntimeExtensionInterface
{
    public function __construct(
        protected ParameterBagInterface $parameterBag,
        protected Packages $packages,
    ) {
    }

    public function assetUploads(string $config, string $path): string
    {
        return $this->packages->getUrl(
            $this->parameterBag->get($config) . '/' . $path
        );
    }
}
