<?php

/**
 * Container for all Task events.
 *
 * This class defines constants for various task-related events that can be dispatched
 * within the task management system. These events include task creation, execution,
 * before and after task execution, task completion, passing, failure, and retrying.
 * It serves as a central point for managing task-related events, allowing for easy
 * identification and handling of these events throughout the application.
 *
 * @package Clicalmani\Task\Event
 * @version 1.0.0
 * @since 1.0.0
 * @author Clicalmani
 * @license https://opensource.org/licenses/MIT MIT License
 */
namespace Clicalmani\Task\Event;

Enum Events
{
    /**
     * Emitted when new new tasks created.
     * 
     * This event is triggered when a new task is created in the system.
     * It allows for additional processing or logging to be performed when a task is created.
     * It can be used to notify other components of the system about the new task,
     * enabling them to take appropriate actions such as scheduling, logging, or triggering
     * notifications.
     * 
     * @var string
     */
    const TASK_CREATE = 'tasks.create';

    /**
     * Emitted when new new tasks created.
     * 
     * This event is triggered when a new task execution is created.
     * It allows for additional processing or logging to be performed when a task execution is created.
     * It can be used to notify other components of the system about the new task execution,
     * enabling them to take appropriate actions such as scheduling, logging, or triggering
     * notifications.
     * 
     * @var string
     */
    const TASK_EXECUTION_CREATE = 'tasks.create_execution';

    /**
     * Emitted when task will be started.
     * 
     * This event is triggered before a task starts executing.
     * It allows for any necessary preparations or checks to be performed before the task execution begins.
     * This can include logging, setting up resources, or validating conditions that must be met before
     * the task can proceed.
     * 
     * @var string
     */
    const TASK_BEFORE = 'tasks.before';

    /**
     * Emitted when task will be started.
     * 
     * This event is triggered after a task has finished executing.
     * It allows for any necessary cleanup or finalization to be performed after the task execution is completed.
     * This can include logging the results, releasing resources, or performing any post-execution
     * actions that are required.
     * 
     * @var string
     */
    const TASK_AFTER = 'tasks.after';

    /**
     * Emitted when after task finished.
     * 
     * This event is triggered when a task has completed its execution.
     * It allows for any necessary actions to be taken after the task has finished,
     * such as updating the task status, notifying other components of the system,
     * or performing any final processing that is required based on the task's outcome.
     * 
     * @var string
     */
    const TASK_FINISHED = 'tasks.finished';

    /**
     * Emitted when task passed.
     * 
     * This event is triggered when a task has successfully passed its execution.
     * It allows for any necessary actions to be taken when a task completes successfully,
     * such as updating the task status to indicate success, logging the successful completion,
     * or triggering any follow-up actions that are required based on the successful execution of the task
     * such as notifications or further processing.
     * 
     * @var string
     */
    const TASK_PASSED = 'tasks.pass';

    /**
     * Emitted when task failed.
     * 
     * This event is triggered when a task has failed during its execution.
     * It allows for any necessary actions to be taken when a task fails, such as updating
     * the task status to indicate failure, logging the error or exception that caused the failure,
     * or triggering any follow-up actions that are required based on the failure of the task.
     * This can include notifying administrators, retrying the task, or performing any necessary cleanup.
     * 
     * @var string
     */
    const TASK_FAILED = 'tasks.failed';

    /**
     * Emitted when task will be retried.
     * 
     * This event is triggered when a task is being retried after a failure.
     * It allows for any necessary actions to be taken before the task is retried,
     * such as logging the retry attempt, resetting any state that needs to be cleared,
     * or performing any preparations that are required before the task is executed again.
     * This can include notifying administrators, adjusting parameters for the retry,
     * or performing any necessary cleanup from the previous attempt.
     * 
     * @var string
     */
    const TASK_RETRIED = 'tasks.retried';
}
