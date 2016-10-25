<?php

namespace LinkService\Domain;

trait RecordsEvents
{
    /**
     * @var object[]
     */
    private $events = [];

    /**
     * @return object[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param object $event
     *
     * @return void
     */
    private function record($event)
    {
        $this->events[] = $event;
    }
}
