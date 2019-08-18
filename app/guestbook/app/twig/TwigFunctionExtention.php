<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Piv\Guestbook\App\Config\{Config, Router};

class TwigFunctionExtention extends AbstractExtension
{

    public function urlFormer(string $nameRoute = 'indexRoute', array $parameters = []): string
    {
        $router = new Router(Config::FILE_OF_ROUTES);
        return $router->setUrl($nameRoute, $parameters);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('url', [$this,'urlFormer']),
        ];
    }
}
