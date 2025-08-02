<?php

/**
 * Schedule class for managing recurring messages.
 *
 * This class allows adding and retrieving recurring messages in a schedule.
 *
 * @package Clicalmani\Task\Scheduler
 * @since 1.0.0
 */
namespace Clicalmani\Task\Scheduler;

use Clicalmani\Foundation\Collection\Collection;
use Clicalmani\Foundation\Collection\CollectionInterface;
use Clicalmani\Task\Messenger\RecurringMessage;

class Schedule
{
    /**
     * @var \Clicalmani\Foundation\Collection\CollectionInterface
     */
    private CollectionInterface $messages;

    public function __construct()
    {
        $this->messages = new Collection;
    }

    public function with(RecurringMessage $message, RecurringMessage ...$messages) : self
    {
        foreach ([$message, ...$messages] as $m) {
            $this->doAdd($m);
        }

        return $this;
    }

    public function getMessages() : CollectionInterface
    {
        return $this->messages;
    }

    private function doAdd(RecurringMessage $message) : void
    {
        $this->messages->add($message);
    }
}