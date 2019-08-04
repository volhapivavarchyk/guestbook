<?php
declare(strict_types=1);

namespace Piv\Guestbook\App;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;
use Piv\Guestbook\App\Controllers\IndexController;
use Piv\Guestbook\App\Http\Response;
use Piv\Guestbook\App\Config\Config;

class AppKernel implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        Config::checkIsDirToUploadedFiles();
        $init = new IndexController();
        $content = $init->show($request);
        $response = new Response ($content['content'], $content['params']);
        return $response;
    }
}
