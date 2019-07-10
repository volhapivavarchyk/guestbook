<?php
declare(strict_types=1);

namespace Guestbook\App\Http;

use Psr\Http\Message\StreamInterface;

trait MessageTrait
{
    protected $headers = [];
    protected $headerNames = [];
    protected $body;
    private $protocol = '1.1';

    public function getProtocolVersion() : string
    {
        return $this->protocol;
    }

    public function withProtocolVersion($version) : self
    {
        $new = clone $this;
        $new->protocol = $version;
        return $new;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    public function hasHeader($header) : bool
    {
        return isset($this->headerNames[strtolower($header)]);
    }

    public function getHeader($header) : array
    {
        if (! $this->hasHeader($header)) {
            return [];
        }

        $header = $this->headerNames[strtolower($header)];
        return $this->headers[$header];
    }

    public function getHeaderLine($name) : string
    {
        $value = $this->getHeader($name);
        if (empty($value)) {
            return '';
        }

        return implode(',', $value);
    }

    public function withHeader($header, $value) : self
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

    public function withAddedHeader($header, $value) : self
    {
        if (! $this->hasHeader($header)) {
            return $this->withHeader($header, $value);
        }

        $header = $this->headerNames[strtolower($header)];

        $new = clone $this;
        $new->headers[$header] = array_merge($this->headers[$header], $value);
        return $new;
    }

    public function withoutHeader($header) : self
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

    public function withBody(StreamInterface $body) : self
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }
}
