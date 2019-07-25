<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Http;

use Psr\Http\Message\{ResponseInterface, StreamInterface};
use Psr\Http\Server\RequestHandlerInterface;
use Piv\Guestbook\App\Config\Config;

class Response implements ResponseInterface
{
    use MessageTrait;

    private $phrases = [
        // SUCCESS CODES
        200 => 'OK',
        // CLIENT ERROR
        400 => 'Bad Request',
        404 => 'Not Found',
    ];

    private $reasonPhrase;
    private $statusCode;
    private $content;
    private $params;

    public function __construct(
        string $content = '',
        array $params = [],
        int $status = 200,
        array $headers = []
    ) {
        $this->setStatusCode($status);
        $this->setContent($content);
        $this->setParams($params);
        $this->setHeaders($headers);
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function withStatus($code, $reasonPhrase = ''): self
    {
        $new = clone $this;
        $new->setStatusCode($code, $reasonPhrase);
        return $new;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    private function setStatusCode(int $code, string $reasonPhrase = ''): void
    {
        if ($reasonPhrase === '' && isset($this->phrases[$code])) {
            $reasonPhrase = $this->phrases[$code];
        }

        $this->reasonPhrase = $reasonPhrase;
        $this->statusCode = (int)$code;
    }

    private function setContent($content): void
    {
        $this->content = $content;
    }

    private function setParams($params): void
    {
        $this->params = $params;
    }

    private function setHeaders($headers): void
    {
        $this->headers = $headers;
    }

    public function send(): void
    {
        extract($this->params);
        include(Config::DIR_APP . '/views/' . $this->content);
    }

}
