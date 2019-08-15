<?php
declare(strict_types=1);

namespace Piv\Guestbook\App;

use Symfony\Component\HttpFoundation\{Request, Response};
use Piv\Guestbook\App\Config\Config;
use Piv\Guestbook\App\Controllers\MessageController;

class Kernel
{
    public function handle(Request $request): Response
    {
        //Config::checkIsDirToUploadedFiles();
        $init = new MessageController();
        $response = $init->show($request);
        return $response;
    }
}
