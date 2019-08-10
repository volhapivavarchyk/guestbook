<?php
declare(strict_types=1);

namespace Piv\Guestbook\App;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Piv\Guestbook\App\Controllers\IndexController;
use Piv\Guestbook\App\Controllers\MessageController;
use Piv\Guestbook\App\Http\Response as MyResponse;
use Piv\Guestbook\App\Config\Config;

class AppKernel
{
    public function handle(Request $request): Response
    {
        //Config::checkIsDirToUploadedFiles();
        $init = new MessageController();
        $response = $init->show($request);
        /*
        $response = new Response(
            $content['content'],
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        */
        return $response;
    }
}
