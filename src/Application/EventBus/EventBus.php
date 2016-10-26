<?php

namespace LinkService\Application\EventBus;

use JsonSerializable;

interface EventBus
{
    /**
     * @param JsonSerializable $event
     *
     * @return void
     */
    public function handle($event);
}
