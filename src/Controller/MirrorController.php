<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Mirror;

class MirrorController extends AbstractController
{
    /**
     * @Route("/{url}", name="app_mirror", requirements={"url": ".*"})
     * @param $url
     * @param Request $request
     * @param Mirror $mirror
     * @return Response
     */
    public function mirror($url, Request $request, Mirror $mirror): Response
    {
        $response = $mirror->getResponse($request, $url);

        return new Response(
            $response->getContent(),
            $response->getStatusCode(),
            $response->getHeaders()
        );
    }
}
