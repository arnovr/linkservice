<?php

namespace LinkService\Infrastructure\Api\Controller;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use LinkService\Application\DeleteLinkHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeleteLinkController
{
    /**
     * @var DeleteLinkHandler
     */
    private $deleteLinkHandler;

    /**
     * @param DeleteLinkHandler $deleteLinkHandler
     */
    public function __construct(DeleteLinkHandler $deleteLinkHandler)
    {
        $this->deleteLinkHandler = $deleteLinkHandler;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);

        try {
            Assertion::notEmpty($payload['trackableLink'] ?? '', 'trackableLink is not set');

            $this->deleteLinkHandler->delete(
                $payload['trackableLink']
            );
        } catch ( InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}