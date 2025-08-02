<?php

namespace Clicalmani\Task\Scheduler;

use Clicalmani\Task\Messenger\RecurringMessage;

interface ScheduleInterface
{
    /**
     * Returns the list of recurring messages in the schedule.
     *
     * @return RecurringMessage[]
     */
    public function getMessages() : \Generator;

    /**
     * Adds a recurring message to the schedule.
     *
     * @param RecurringMessage $message
     * @param RecurringMessage ...$messages
     * @return self
     */
    public function with(RecurringMessage $message, RecurringMessage ...$messages) : self;
}