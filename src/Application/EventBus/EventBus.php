<?php

namespace LinkService\Application\EventBus;

interface EventBus
{
    /**
     * @param object $event
     *
     * @return void
     */
    public function handle($event);
}
