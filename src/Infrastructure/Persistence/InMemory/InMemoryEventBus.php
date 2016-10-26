<?php
declare(strict_types=1);

namespace LinkService\Infrastructure\Persistence\InMemory;

use LinkService\Application\EventBus\EventBus;

class InMemoryEventBus implements EventBus
{
    /**
     * @var array
     */
    private $events = [];

    /**
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        $this->events[] = $event;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
