<?php

namespace Piv\Guestbook\App\Http;

use Psr\Http\Message\{MessageInterface, StreamInterface};

trait MessageTrait
{
    protected $headers = [];
    protected $headerNames = [];
    protected $body;
    private $protocol = '1.1';

    public function getProtocolVersion(): string
    {
        return $this->protocol;
    }

    public function withProtocolVersion($version): self
    {
        $new = clone $this;
        $new->protocol = $version;
        return $new;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader($name): bool
    {
        return isset($this->headerNames[strtolower($name)]);
    }

    public function getHeader($name): array
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        $header = $this->headerNames[strtolower($name)];
        return $this->headers[$header];
    }

    public function getHeaderLine($name): string
    {
        $value = $this->getHeader($name);
        if (empty($value)) {
            return '';
        }

        return implode(',', $value);
    }

    public function withHeader($header, $value): self
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

    public function withAddedHeader($header, $value): self
    {
        if (!$this->hasHeader($header)) {
            return $this->withHeader($header, $value);
        }

        $header = $this->headerNames[strtolower($header)];

        $new = clone $this;
        $new->headers[$header] = array_merge($this->headers[$header], $value);
        return $new;
    }

    public function withoutHeader($header): self
    {
        if (!$this->hasHeader($header)) {
            return clone $this;
        }

        $normalized = strtolower($header);
        $original = $this->headerNames[$normalized];

        $new = clone $this;
        unset($new->headers[$original], $new->headerNames[$normalized]);
        return $new;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body): self
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }
}
