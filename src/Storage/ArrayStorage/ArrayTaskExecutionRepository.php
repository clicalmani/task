<?php

/*
 * This file is part of php-task library.
 *
 * (c) php-task
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Clicalmani\Task\Storage\ArrayStorage;

use Clicalmani\Foundation\Collection\Collection;
use Clicalmani\Foundation\Collection\CollectionInterface;
use Clicalmani\Task\Execution\TaskExecution;
use Clicalmani\Task\Execution\TaskExecutionInterface;
use Clicalmani\Task\Storage\TaskExecutionRepositoryInterface;
use Clicalmani\Task\TaskInterface;
use Clicalmani\Task\TaskStatus;

/**
 * Storage task-execution in an array.
 */
class ArrayTaskExecutionRepository implements TaskExecutionRepositoryInterface
{
    /**
     * @var \Clicalmani\Foundation\Collection\CollectionInterface
     */
    private $taskExecutionCollection;

    /**
     * @param Collection $taskExecutions
     */
    public function __construct(?CollectionInterface $taskExecutions = null)
    {
        $this->taskExecutionCollection = $taskExecutions ?? new Collection();
    }

    /**
     * {@inheritdoc}
     */
    public function create(TaskInterface $task, \DateTime $scheduleTime)
    {
        return new TaskExecution($task, $task->getHandlerClass(), $scheduleTime, $task->getWorkload());
    }

    /**
     * {@inheritdoc}
     */
    public function save(TaskExecutionInterface $execution)
    {
        if ($this->taskExecutionCollection->contains($execution)) {
            return $this;
        }
        
        $this->taskExecutionCollection->add($execution);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(TaskExecutionInterface $execution)
    {
        $this->taskExecutionCollection->remove($execution);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function findPending(TaskInterface $task)
    {
        $filtered = $this->taskExecutionCollection->filter(
            function (TaskExecutionInterface $execution) use ($task) {
                return $execution->getTask()->getUuid() === $task->getUuid()
                    && in_array($execution->getStatus(), [TaskStatus::PLANNED, TaskStatus::RUNNING]);
            }
        );

        if (0 === $filtered->count()) {
            return;
        }

        return $filtered->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByUuid($uuid)
    {
        $filtered = $this->taskExecutionCollection->filter(
            function (TaskExecutionInterface $execution) use ($uuid) {
                return $execution->getUuid() === $uuid;
            }
        );

        if (0 === $filtered->count()) {
            return;
        }

        return $filtered->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByTask(TaskInterface $task)
    {
        return $this->findByTaskUuid($task->getUuid());
    }

    /**
     * {@inheritdoc}
     */
    public function findByTaskUuid($taskUuid)
    {
        return array_values(
            $this->taskExecutionCollection->filter(
                function (TaskExecutionInterface $execution) use ($taskUuid) {
                    return $execution->getTask()->getUuid() === $taskUuid;
                }
            )->toArray()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($page = 1, $pageSize = null)
    {
        return array_values($this->taskExecutionCollection->slice(($page - 1) * $pageSize, $pageSize));
    }

    /**
     * {@inheritdoc}
     */
    public function findNextScheduled(?\DateTime $dateTime = null, array $skippedExecutions = [])
    {
        $dateTime = $dateTime ?: new \DateTime();
        
        $result = $this->taskExecutionCollection->filter(
            function (TaskExecutionInterface $execution) use ($dateTime, $skippedExecutions) {
                return TaskStatus::PLANNED === $execution->getStatus()
                    && $execution->getTask()->getInterval()->isDue()
                    && !in_array($execution->getUuid(), $skippedExecutions);
            }
        )->first();
        
        return $result ?: null;
    }
}
