<?php
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

    public function with(RecurringMessage $message, RecurringMessage ...$messages)
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

    private function doAdd(RecurringMessage $message) 
    {
        $this->messages->add($message);
    }
}