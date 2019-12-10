<?php
declare(strict_types=1);

namespace Piv\Guestbook\Twig;

use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class TwigFunctionExtension extends AbstractExtension
{

    public function getUrl(string $shortUrl = ''): string
    {
        $package = new Package(new JsonManifestVersionStrategy($_ENV['FILE_OF_MANIFEST']));
        return $package->getUrl($shortUrl);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', [$this,'getUrl']),
        ];
    }
}
