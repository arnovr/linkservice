<?php
declare(strict_types=1);

namespace LinkService\Infrastructure\Api\Controller;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use LinkService\Application\DeleteLinkHandler;
use LinkService\Domain\Model\TrackableLinkNotFound;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            Assertion::notEmpty($payload['referrer'] ?? '', 'referrer is not set');

            $this->deleteLinkHandler->delete(
                $payload['referrer']
            );

            return new Response('', Response::HTTP_NO_CONTENT);
        } catch (TrackableLinkNotFound $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
