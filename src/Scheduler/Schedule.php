<?php
namespace Clicalmani\Task\Scheduler;

use Clicalmani\Task\Builder\TaskBuilderFactory;
use Clicalmani\Task\Executor\InsideProcessExecutor;
use Clicalmani\Task\Handler\TaskHandlerFactory;
use Clicalmani\Task\Messenger\RecurringMessage;
use Clicalmani\Task\Storage\ArrayStorage\ArrayTaskExecutionRepository;
use Clicalmani\Task\Storage\ArrayStorage\ArrayTaskRepository;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Schedule
{
    private $scheduler;

    public function __construct(private ?EventDispatcher $dispatcher = null)
    {
        $this->scheduler = new TaskScheduler(
            new TaskBuilderFactory,
            new ArrayTaskRepository,
            new ArrayTaskExecutionRepository,
            $this->dispatcher
        );
    }

    public function with(RecurringMessage $message, RecurringMessage ...$messages)
    {
        foreach ([$message, ...$messages] as $m) {
            $this->doAdd($m);
        }

        return $this;
    }

    private function doAdd(RecurringMessage $message) 
    {
        $this->scheduler->createTask($message->getHandler(), $message->getWorkload());
    }
}