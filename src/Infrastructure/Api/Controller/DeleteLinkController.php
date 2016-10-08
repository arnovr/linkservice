<?php


namespace LinkService\Infrastructure\Api\Controller;


use Symfony\Component\HttpFoundation\Response;

class DeleteLinkController
{
    public function deleteAction(): Response
    {
        return new Response('', Response::HTTP_NO_CONTENT);
    }
}