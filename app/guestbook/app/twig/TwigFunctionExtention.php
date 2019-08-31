<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Twig;

use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Piv\Guestbook\App\Config\Config;
use Piv\Guestbook\App\Routing\Router;

class TwigFunctionExtention extends AbstractExtension
{
    public function urlFormer(string $nameRoute = 'indexRoute', array $parameters = []): string
    {
        $router = new Router(Config::FILE_OF_ROUTES);
        return $router->setUrl($nameRoute, $parameters);
    }

    public function getUrl(string $shortUrl = ''): string
    {
        $package = new Package(new JsonManifestVersionStrategy(Config::FILE_OF_MANIFEST));
        return $package->getUrl($shortUrl);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('url', [$this,'urlFormer']),
            new TwigFunction('asset', [$this,'getUrl']),
        ];
    }
}
