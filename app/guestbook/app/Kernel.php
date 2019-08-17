<?php
declare(strict_types=1);

namespace Piv\Guestbook\App;

use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\{Route, RouteCollection, RequestContext};
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Piv\Guestbook\App\Config\Config;
use Piv\Guestbook\App\Controllers\IndexController;

class Kernel implements HttpKernelInterface
{
    protected $routes;

    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true): Response
    {
        //Config::checkIsDirToUploadedFiles();
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $attributes = $matcher->match($request->getPathInfo());
            $controller = $attributes['controller'];
            $response = IndexController::$controller($request);
        } catch(ResourceNotFoundException $e) {
            //$response = IndexController::show($request);
            $response = new Response('Not found!', Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    public function map($path, $controller)
    {
        $this->routes->add($path, new Route(
            $path,
            ['controller' => $controller]
        ));
    }
}
