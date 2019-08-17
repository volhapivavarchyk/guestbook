<?php
declare(strict_types=1);

namespace Piv\Guestbook\App;

use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Piv\Guestbook\App\Config\Config;
use Piv\Guestbook\App\Controllers\IndexController;

class Kernel implements HttpKernelInterface
{
    protected $routes = [];

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true): Response
    {
        //Config::checkIsDirToUploadedFiles();
        $path = $request->getPathInfo();
        if (array_key_exists($path, $this->routes)) {
            $controller = $this->routes[$path];
            $response = IndexController::$controller($request);
        } else {
            $response = IndexController::show($request);
        }
        return $response;
    }

    public function map($path, $controller)
    {
        $this->routes[$path] = $controller;
    }
}
