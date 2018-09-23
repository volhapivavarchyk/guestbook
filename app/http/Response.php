<?php
namespace Guestbook\App\Http;

use Psr\Http\Message\ResponseInterface;

use function gettype;
use function is_float;
use function is_numeric;
use function is_scalar;
use function sprintf;

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

    public function __construct($content = '', $params = '',  $status = 200, array $headers = [])
    {
        $this->setStatusCode($status);
        $this->setContent($content);
        $this->setParams($params);
        $this->setHeaders($headers);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    public function withStatus($code, $reasonPhrase = '')
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

    private function setContent($content)
    {
      $this->content = $content;
    }

    private function setParams($params)
    {
      $this->params = $params;
    }

    private function setHeaders($headers)
    {
      $this->headers = $headers;
    }

    public function send()
    {
        extract($this->params);
        include(DIR_APP.'/views/'.$this->content);
    }

}
