<?php

namespace App\Util;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Cookie;

class MirrorResponse
{
    protected $code;
    protected $headers;
    protected $content;
    protected $domain;

    public function __construct(ResponseInterface $response, string $domain)
    {
        $this->domain = $domain;
        $this->setHeaders($response);
        $this->setContent($response);
        $this->setStatusCode($response);
    }

    public function setHeaders(ResponseInterface $response) : self
    {
        $headers = $response->getHeaders();

        $headers = array_change_key_case($headers);

        unset($headers['transfer-encoding']);
        unset($headers['eontent-encoding']);

        if (isset($headers['location'])) {
            $headers['location'] = array_map(function ($item) {
                return str_replace($this->domain, '/', $item);
            }, $headers['location']);
        }

        if (isset($headers['set-cookie'])) {
            foreach ($headers['set-cookie'] as $index => $cookie) {
                $headers['set-cookie'][$index] = \preg_replace('/ domain\=([A-Za-z\.0-9-]+);?/i', '', $cookie);
            }
        }

        $this->headers = $headers;

        return $this;
    }

    public function setContent(ResponseInterface $response) : self
    {
        $this->content = (string) $response->getBody();

        return $this;
    }

    public function setStatusCode(ResponseInterface $response) : self
    {
        $this->code = $response->getStatusCode();

        return $this;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function getStatusCode() : int
    {
        return $this->code;
    }
}