<?php

/**
 * Task builder factory.
 *
 * This factory creates instances of TaskBuilder, which is used to build tasks with various scheduling options.
 *
 * @package Clicalmani\Task\Builder
 * @since 1.0.0
 */
namespace Clicalmani\Task\Builder;

use Clicalmani\Task\Scheduler\TaskSchedulerInterface;
use Clicalmani\Task\TaskInterface;

class TaskBuilderFactory implements TaskBuilderFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createTaskBuilder(TaskInterface $task, TaskSchedulerInterface $taskScheduler) : TaskBuilderInterface
    {
        return new TaskBuilder($task, $taskScheduler);
    }
}
