<?php

/**
 * Task Execution Events are triggered by the Scheduler during scheduling and run process.
 *
 * This class represents events related to task execution, such as task execution start, completion, and failure.
 * It extends the TaskEvent class and provides a way to encapsulate task execution-related data within events.
 * The TaskExecutionEvent class is used to pass task execution information to event listeners, allowing
 * them to react to changes in task execution state or to perform actions based on task execution events
 * such as logging, notifications, or further processing.
 *
 * @package Clicalmani\Task\Event
 * @version 1.0.0
 * @since 1.0.0
 * @author Clicalmani
 * @license https://opensource.org/licenses/MIT MIT License
 */
namespace Clicalmani\Task\Event;

use Clicalmani\Task\Execution\TaskExecutionInterface;
use Clicalmani\Task\TaskInterface;

class TaskExecutionEvent extends TaskEvent
{
    /**
     * @var TaskExecutionInterface
     */
    private $taskExecution;

    /**
     * @param TaskInterface $task
     * @param TaskExecutionInterface $taskExecution
     */
    public function __construct(TaskInterface $task, TaskExecutionInterface $taskExecution)
    {
        parent::__construct($task);

        $this->taskExecution = $taskExecution;
    }

    /**
     * Returns the task execution associated with the event.
     *
     * @return TaskExecutionInterface
     */
    public function getTaskExecution()
    {
        return $this->taskExecution;
    }
}
