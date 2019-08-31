<?php
namespace Piv\Guestbook\App\Routing;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class Router
{
    protected $routes;
    protected $context;
    protected $matcher;
    protected $generator;

    public function __construct(string $fileOfRoutes)
    {
        $fileLocator = new FileLocator([__DIR__]);
        $loader = new YamlFileLoader($fileLocator);
        $this->routes = $loader->load($fileOfRoutes);

        $this->context = new RequestContext();
        //$this->context->fromRequest(Request::createFromGlobals());
        $this->matcher = new UrlMatcher($this->routes, $this->context);
        $this->generator = new UrlGenerator($this->routes, $this->context);
    }

    public function getUrlParameters(string $urlPath): array
    {
        return $this->matcher->match($urlPath);
    }

    public function setUrl(string $nameRoute, array $parameters)
    {
        return $this->generator->generate($nameRoute, $parameters);
    }
}
