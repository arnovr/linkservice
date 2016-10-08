<?php


namespace LinkService\Infrastructure\Api\Controller;


use Assert\Assertion;
use Assert\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateLinkController
{
    public function createAction(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);

        try {
            Assertion::notEmpty($payload['link'] ?? '', 'Link is not set');
            Assertion::notEmpty($payload['trackableLink'] ?? '', 'trackableLink is not set');
            Assertion::url($payload['link'], 'link should be a valid url');
        } catch ( InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return new Response('', Response::HTTP_CREATED);
    }

}