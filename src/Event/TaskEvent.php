<?php

/**
 * Task Event class for handling task-related events.
 *
 * This class is used to encapsulate task-related data within events, allowing event listeners
 * to react to changes in task state or to perform actions based on task events.
 *
 * @package Clicalmani\Task\Event
 * @since 1.0.0
 */
namespace Clicalmani\Task\Event;

use Clicalmani\Task\TaskInterface;

class TaskEvent extends BaseEvent
{
    /**
     * Task instance associated with the event.
     * 
     * This property holds the task that is associated with the event.
     * It allows event listeners to access the task data and perform actions based on the task's
     * state or properties.
     * 
     * @var TaskInterface
     */
    private $task;

    /**
     * @param TaskInterface $task
     */
    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * Returns the task associated with the event.
     *
     * @return TaskInterface
     */
    public function getTask()
    {
        return $this->task;
    }
}
