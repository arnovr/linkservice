<?php
declare(strict_types=1);

namespace LinkService\Infrastructure\Persistence\Mysql;

use LinkService\Application\ClickRepository;
use LinkService\Domain\Model\TrackableLink;
use PDO;

class MysqlClickRepository implements ClickRepository
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function add(TrackableLink $trackableLink)
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO clicks (created, trackable_link) VALUES(:created, :trackable_link)'
        );
        $statement->execute(
            [
                'created' => date("d-m-Y H:i:s"),
                'trackable_link' => (string) $trackableLink->trackableLink()
            ]
        );
    }
}
