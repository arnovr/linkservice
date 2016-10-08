<?php
declare(strict_types=1);

namespace LinkService\Infrastructure\Api\Controller;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use LinkService\Application\Command\CreateLinkCommand;
use LinkService\Application\CreateLinkHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateLinkController
{
    /**
     * @var CreateLinkHandler
     */
    private $createLinkHandler;

    /**
     * @param CreateLinkHandler $createLinkHandler
     */
    public function __construct(CreateLinkHandler $createLinkHandler)
    {
        $this->createLinkHandler = $createLinkHandler;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);

        try {
            $this->createLinkHandler->create(
                $this->createLinkCommandFromPayload($payload)
            );
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @param array $payload
     * @return CreateLinkCommand
     */
    private function createLinkCommandFromPayload(array $payload): CreateLinkCommand
    {
        Assertion::notEmpty($payload['link'] ?? '', 'Link is not set');
        Assertion::notEmpty($payload['trackableLink'] ?? '', 'trackableLink is not set');
        Assertion::url($payload['link'], 'link should be a valid url');

        $command = new CreateLinkCommand();
        $command->link = $payload['link'];
        $command->trackableLink = $payload['trackableLink'];

        return $command;
    }
}
