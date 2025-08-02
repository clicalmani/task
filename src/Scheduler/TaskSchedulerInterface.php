<?php

/**
 * Task scheduler interface.
 *
 * This interface defines methods for creating, adding, and scheduling tasks.
 *
 * @package Clicalmani\Task\Scheduler
 * @since 1.0.0
 */
namespace Clicalmani\Task\Scheduler;

use Clicalmani\Task\Builder\TaskBuilderInterface;
use Clicalmani\Task\TaskInterface;

interface TaskSchedulerInterface
{
    /**
     * Returns new task-builder.
     *
     * @param string $handlerClass
     * @param ?object $workload
     * @return TaskBuilderInterface
     */
    public function createTask(string $handlerClass, ?object $workload = null) : TaskBuilderInterface;

    /**
     * Schedule task.
     *
     * @param TaskInterface $task
     * @return self
     */
    public function addTask(TaskInterface $task) : self;

    /**
     * Schedules task-executions.
     */
    public function scheduleTasks() : void;
}

