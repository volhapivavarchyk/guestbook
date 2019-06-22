<?php
namespace Guestbook\App\Http;

use Psr\Http\Message\StreamInterface;

trait MessageTrait
{
    protected $headers = [];
    protected $headerNames = [];
    private $protocol = '1.1';

    public function getProtocolVersion()
    {
        return $this->protocol;
        var_dump($this->protocol);
    }

    public function withProtocolVersion($version)
    {
        $new = clone $this;
        $new->protocol = $version;
        var_dump($version);
        return $new;
    }

    public function getHeaders()
    {
        return $this->headers;
        var_dump($this->headers);
    }

    public function hasHeader($header)
    {
        return isset($this->headerNames[strtolower($header)]);
    }

    public function getHeader($header)
    {
        if (! $this->hasHeader($header)) {
            return [];
        }

        $header = $this->headerNames[strtolower($header)];
        return $this->headers[$header];
    }

    public function getHeaderLine($name)
    {
        $value = $this->getHeader($name);
        var_dump($name);
        if (empty($value)) {
            return '';
        }

        return implode(',', $value);
    }

    public function withHeader($header, $value)
    {
        $normalized = strtolower($header);

        $new = clone $this;
        if ($new->hasHeader($header)) {
            unset($new->headers[$new->headerNames[$normalized]]);
        }

        $new->headerNames[$normalized] = $header;
        $new->headers[$header] = $value;

        return $new;
    }

    public function withAddedHeader($header, $value)
    {
        if (! $this->hasHeader($header)) {
            return $this->withHeader($header, $value);
        }

        $header = $this->headerNames[strtolower($header)];

        $new = clone $this;
        $new->headers[$header] = array_merge($this->headers[$header], $value);
        return $new;
    }

    public function withoutHeader($header)
    {
        if (! $this->hasHeader($header)) {
            return clone $this;
        }

        $normalized = strtolower($header);
        $original   = $this->headerNames[$normalized];

        $new = clone $this;
        unset($new->headers[$original], $new->headerNames[$normalized]);
        return $new;
    }

    public function withBody(StreamInterface $body)
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }
}
