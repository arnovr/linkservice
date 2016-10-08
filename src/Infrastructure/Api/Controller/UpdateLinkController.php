<?php


namespace LinkService\Infrastructure\Api\Controller;


use Assert\Assertion;
use Assert\InvalidArgumentException;
use LinkService\Application\Command\UpdateLinkCommand;
use LinkService\Application\UpdateLinkHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateLinkController
{
    /**
     * @var UpdateLinkHandler
     */
    private $updateLinkHandler;

    /**
     * @param UpdateLinkHandler $updateLinkHandler
     */
    public function __construct(UpdateLinkHandler $updateLinkHandler)
    {
        $this->updateLinkHandler = $updateLinkHandler;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);

        try {
            $this->updateLinkHandler->update(
                $this->createUpdateLinkCommandFromPayload($payload)
            );
        } catch ( InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $payload
     * @return UpdateLinkCommand
     */
    private function createUpdateLinkCommandFromPayload($payload): UpdateLinkCommand
    {
        Assertion::notEmpty($payload['link'] ?? '', 'Link is not set');
        Assertion::notEmpty($payload['trackableLink'] ?? '', 'trackableLink is not set');
        Assertion::url($payload['link'], 'link should be a valid url');

        $command = new UpdateLinkCommand();
        $command->link = $payload['link'];
        $command->trackableLink = $payload['trackableLink'];

        return $command;
    }
}