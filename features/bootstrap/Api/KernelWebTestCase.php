<?php


namespace BehatTests\Api;

use LinkService\Application\ClickRepository;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkRepository;
use LinkService\Infrastructure\Persistence\InMemory\InMemoryTrackableLinkRepository;
use Mockery;
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
     * @var ClickRepository|\Mockery\Mock
     */
    protected $clickRepository;

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
     * @param $clicks
     */
    protected function shouldAddTrackableLinkRepository($trackableLink, $link, $clicks)
    {
        $this->trackableLinkRepository = new InMemoryTrackableLinkRepository(
            [
                TrackableLink::from(
                    new Referrer($trackableLink),
                    new Link($link),
                    $clicks
                )
            ]
        );

        $this->addRepositoryToContainer($this->trackableLinkRepository);
    }

    protected function shouldAddClickableRepositoryMock() {
        $this->clickRepository = Mockery::spy(ClickRepository::class);
        $this->client->getContainer()->set(
            'link_service.infrastructure.persistence.mysql.mysql_click_repository',
            $this->clickRepository
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