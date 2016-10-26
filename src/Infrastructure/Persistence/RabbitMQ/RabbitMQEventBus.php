<?php
declare(strict_types=1);

namespace LinkService\Infrastructure\Persistence\RabbitMQ;

use JsonSerializable;
use LinkService\Application\EventBus\EventBus;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class RabbitMQEventBus implements EventBus
{
    /**
     * @var ProducerInterface
     */
    private $producer;

    /**
     * @param ProducerInterface $producer
     */
    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
    }

    /**
     * @param JsonSerializable $event
     *
     * @return void
     */
    public function handle($event)
    {
        $this->producer->publish(json_encode($event), 'event.click');
    }
}
