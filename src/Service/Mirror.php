<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use App\Util\MirrorResponse;
use GuzzleHttp\Client;

class Mirror
{
    /** @var string */
    protected $domain;

    /** @var GuzzleHttp\Client */
    protected $client;

    public function __construct(string $domain)
    {
        $this->domain = $domain;
        $this->client = new Client(['base_uri' => $domain]);
    }

    public function getResponse(Request $request, string $url) : MirrorResponse
    {
        $opts = [
            'headers' => $request->headers->all(),
            'allow_redirects' => false,
        ];

        unset($opts['headers']['host']);
        unset($opts['headers']['content-type']);
        unset($opts['headers']['content-length']);

        if ($request->getContent()) $opts['body'] = $request->getContent();

        $response = $this->client->request($request->getMethod(), $url, $opts);

        return new MirrorResponse($response, $this->domain, $url);
    }
}