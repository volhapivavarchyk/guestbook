<?php
declare(strict_types=1);

namespace Guestbook\App\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\StreamInterface;

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

    public function __construct(string $content = '', array $params = '', int $status = 200, array $headers = [])
    {
        $this->setStatusCode($status);
        $this->setContent($content);
        $this->setParams($params);
        $this->setHeaders($headers);
    }

    public function getStatusCode() : string
    {
        return $this->statusCode;
    }

    public function getReasonPhrase() : string
    {
        return $this->reasonPhrase;
    }

    public function getBody() : string
    {
        return $this->content;
    }

    public function withStatus($code, $reasonPhrase = '') : self
    {
        $new = clone $this;
        $new->setStatusCode($code, $reasonPhrase);
        return $new;
    }

    private function setStatusCode($code, $reasonPhrase = '')
    {
        if ($reasonPhrase === '' && isset($this->phrases[$code])) {
            $reasonPhrase = $this->phrases[$code];
        }

        $this->reasonPhrase = $reasonPhrase;
        $this->statusCode = (int) $code;
    }

    private function setContent($content) : void
    {
      $this->content = $content;
    }

    private function setParams($params) : void
    {
      $this->params = $params;
    }

    private function setHeaders($headers) : void
    {
      $this->headers = $headers;
    }

    public function send() : void
    {
        extract($this->params);
        include(DIR_APP.'/views/'.$this->content);
    }

}
