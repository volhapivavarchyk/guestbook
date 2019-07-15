<?php
declare(strict_types=1);

namespace Guestbook\App\Controllers;

use Psr\Http\Message\ServerRequestInterface;

abstract class ABaseController
{
    abstract public function show(ServerRequestInterface $request): array;
}
