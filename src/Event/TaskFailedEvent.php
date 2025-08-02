<?php

/**
 * TaskFailedEvent class for handling task failure events.
 *
 * This class is used to encapsulate the details of a task that has failed,
 * including the task itself and the exception that caused the failure.
 *
 * @package Clicalmani\Task\Event
 * @since 1.0.0
 */
namespace Clicalmani\Task\Event;

use Clicalmani\Task\TaskInterface;

class TaskFailedEvent extends TaskEvent
{
    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @param TaskInterface $task
     * @param \Exception $exception
     */
    public function __construct(TaskInterface $task, \Exception $exception)
    {
        parent::__construct($task);

        $this->exception = $exception;
    }

    /**
     * Returns exception which was thrown by the task.
     *
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}
