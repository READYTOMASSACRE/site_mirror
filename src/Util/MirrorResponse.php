<?php

namespace App\Util;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Cookie;
use App\Util\Content\HousePlans;

class MirrorResponse
{
    protected $code;
    protected $headers;
    protected $content;
    protected $domain;

    public function __construct(ResponseInterface $response, string $domain, string $url)
    {
        $this->domain = $domain;
        $this->url = $url;
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

        $headers = $this->getHeaders();

        if (
            isset($headers['content-type'])
            && strpos(current($headers['content-type']), 'text/html') !== false
        ) {
            $contentParser = null;

            switch ($this->domain) {
                case 'https://www.houseplans.com/':
                    $contentParser = new HousePlans($this->content);
                    break;
            }

            if ($contentParser) $this->content = $contentParser->getContent();
        }

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