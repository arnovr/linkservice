<?php


namespace LinkService\Infrastructure\Api\Controller;


use Symfony\Component\HttpFoundation\Response;

class LinkController
{
    /**
     * LinkController constructor.
     */
    public function __construct()
    {
    }

    public function createAction(): Response
    {
        return new Response('', Response::HTTP_CREATED);
    }

    public function updateAction(): Response
    {
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function deleteAction(): Response
    {
        return new Response('', Response::HTTP_NO_CONTENT);
    }
}