<?php

namespace Tests\LinkService\Infrastructure\Persistence\Mysql;


use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Infrastructure\Persistence\Mysql\MysqlClickRepository;
use Mockery;
use PDO;

class MysqlClickRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MysqlClickRepository
     */
    private $repository;

    /**
     * @var PDO|\Mockery\Mock
     */
    private $pdo;

    public function setUp()
    {
        $this->pdo = Mockery::mock(PDO::class);
        $this->repository = new MysqlClickRepository(
            $this->pdo
        );
    }

    /**
     * @test
     */
    public function shouldPersistClick()
    {
        $this->pdo->shouldReceive('prepare')->once()->andReturnSelf();
        $this->pdo->shouldReceive('execute')->with(
            Mockery::on(function(array $statement) {
                $this->assertNotEmpty($statement['created'] ?? '');
                $this->assertSame('some/awesome/path', $statement['trackable_link'] ?? '');
                return true;
            }
        ))->once();

        $this->repository->add(
            TrackableLink::from(
                new Link('some/awesome/path'),
                new Link('http://www.fulllink.com'),
                0
            )
        );
    }


}