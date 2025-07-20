<?php

/*
 * This file is part of php-task library.
 *
 * (c) php-task
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Clicalmani\Task\Builder;

use Clicalmani\Task\Scheduler\TaskSchedulerInterface;
use Clicalmani\Task\TaskInterface;

/**
 * Interface for task builder factory.
 */
interface TaskBuilderFactoryInterface
{
    /**
     * Returns new task-builder.
     *
     * @param \Clicalmani\Task\TaskInterface $task
     * @param \Clicalmani\Task\Scheduler\TaskSchedulerInterface $taskScheduler
     *
     * @return Clicalmani\Task\Builder\TaskBuilderInterface
     */
    public function createTaskBuilder(TaskInterface $task, TaskSchedulerInterface $taskScheduler) : TaskBuilderInterface;
}
