<?php

namespace LinkService\Infrastructure\Web\Controller;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use LinkService\Application\Command\CreateLinkCommand;
use LinkService\Application\CreateLinkHandler;
use LinkService\Application\ReferrerExists;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Templating\EngineInterface;

class PageController
{
    /**
     * @var EngineInterface
     */
    private $template;

    /**
     * @var CreateLinkHandler
     */
    private $createLinkHandler;

    /**
     * @param EngineInterface   $template
     * @param CreateLinkHandler $createLinkHandler
     */
    public function __construct(
        EngineInterface $template,
        CreateLinkHandler $createLinkHandler
    ) {
        $this->template = $template;
        $this->createLinkHandler = $createLinkHandler;
    }

    /**
     *
     */
    public function shortenLinkAction(Request $request): Response
    {
        $url = $request->request->get('url');

        try {
            $payload = [
                'referrer' => $this->generateRandomString(5),
                'link' => $url
            ];

            $this->createLinkHandler->create(
                $this->createLinkCommandFromPayload(
                    $payload
                )
            );

            return new Response(
                $this->template->render('@linkservice/referrer.html.twig', $payload)
            );
        } catch (ReferrerExists $e) {
            throw new ConflictHttpException($e->getMessage());
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @return Response
     */
    public function viewAction(): Response
    {
        return new Response(
            $this->template->render('@linkservice/page.html.twig')
        );
    }

    /**
     * @param array $payload
     * @return CreateLinkCommand
     */
    private function createLinkCommandFromPayload(array $payload): CreateLinkCommand
    {
        Assertion::notEmpty($payload['link'] ?? '', 'Link is not set');
        Assertion::notEmpty($payload['referrer'] ?? '', 'referrer is not set');
        Assertion::url($payload['link'], 'link should be a valid url');

        $command = new CreateLinkCommand();
        $command->link = $payload['link'];
        $command->referrer = $payload['referrer'];

        return $command;
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateRandomString($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
