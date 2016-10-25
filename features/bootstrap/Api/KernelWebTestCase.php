<?php


namespace BehatTests\Api;

use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkRepository;
use LinkService\Infrastructure\Persistence\InMemory\InMemoryEventBus;
use LinkService\Infrastructure\Persistence\InMemory\InMemoryTrackableLinkRepository;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

$_SERVER['KERNEL_DIR'] = __DIR__ . '/../../../app/';

class KernelWebTestCase extends WebTestCase
{
    /**
     * @var InMemoryTrackableLinkRepository
     */
    protected $trackableLinkRepository;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var InMemoryEventBus
     */
    protected $eventBus;

    public function __construct()
    {
        $this->client = self::createClient();
        parent::__construct();

        $this->trackableLinkRepository = new InMemoryTrackableLinkRepository([]);
        $this->addRepositoryToContainer($this->trackableLinkRepository);
    }

    /**
     * @param $trackableLink
     * @param $link
     */
    protected function shouldAddTrackableLinkRepository($trackableLink, $link)
    {
        $this->trackableLinkRepository = new InMemoryTrackableLinkRepository(
            [
                TrackableLink::from(
                    new Referrer($trackableLink),
                    new Link($link)
                )
            ]
        );

        $this->addRepositoryToContainer($this->trackableLinkRepository);
    }

    protected function shouldAddEventBus()
    {
        $this->eventBus = new InMemoryEventBus();

        $this->client->getContainer()->set(
            '@link_service.infrastructure.persistence.event_bus',
            $this->eventBus
        );
    }

    private function addRepositoryToContainer(TrackableLinkRepository $repository)
    {
        $this->client->getContainer()->set(
            'link_service.infrastructure.persistence.trackable_link_repository',
            $repository
        );
    }
}
