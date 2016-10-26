<?php

namespace Tests\LinkService\Infrastructure\Persistence\RabbitMQ;

use LinkService\Infrastructure\Persistence\RabbitMQ\RabbitMQEventBus;
use Mockery;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class RabbitMQEventBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RabbitMQEventBus
     */
    private $eventBus;

    /**
     * @var ProducerInterface|\Mockery\Mock
     */
    private $producer;

    public function setUp()
    {
        $this->producer = Mockery::spy(ProducerInterface::class);
        $this->eventBus = new RabbitMQEventBus(
            $this->producer
        );
    }

    /**
     * @test
     */
    public function shouldPublishEventOnBus()
    {
        $event = Mockery::mock(\JsonSerializable::class);
        $event->shouldReceive('jsonSerialize')->andReturn(['hello' => 'world']);
        
        $this->eventBus->handle($event);

        $this->producer
            ->shouldHaveReceived('publish')
            ->with(
                Mockery::on(
                    function(string $encoded) {
                        $event = json_decode($encoded, true);
                        $this->assertNotEmpty($event);
                        $this->assertSame('world', $event['hello']);
                        return true;
                    }
                ),
                Mockery::type('string')
            );
    }
}
