<?php

/**
 * Task Builder Factory Interface.
 *
 * This interface defines a method to create task builders, which are used to build tasks with various scheduling options.
 * It provides methods to create task builders with different intervals such as hourly, daily, weekly,
 * monthly, and yearly, as well as custom cron expressions.
 *
 * @package Clicalmani\Task\Builder
 * @since 1.0.0
 */
namespace Clicalmani\Task\Builder;

use Clicalmani\Task\Scheduler\TaskSchedulerInterface;
use Clicalmani\Task\TaskInterface;

interface TaskBuilderFactoryInterface
{
    /**
     * Returns new task-builder.
     *
     * @param TaskInterface $task
     * @param TaskSchedulerInterface $taskScheduler
     *
     * @return TaskBuilderInterface
     */
    public function createTaskBuilder(TaskInterface $task, TaskSchedulerInterface $taskScheduler) : TaskBuilderInterface;
}
