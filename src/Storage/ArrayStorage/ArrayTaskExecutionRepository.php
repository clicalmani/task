<?php

/**
 * Task execution repository interface.
 *
 * This interface defines methods for managing task executions, including creating, saving, removing,
 * and finding task executions based on various criteria.
 *
 * @package Clicalmani\Task\Storage
 * @since 1.0.0
 */
namespace Clicalmani\Task\Storage\ArrayStorage;

use Clicalmani\Foundation\Collection\Collection;
use Clicalmani\Foundation\Collection\CollectionInterface;
use Clicalmani\Task\Execution\TaskExecution;
use Clicalmani\Task\Execution\TaskExecutionInterface;
use Clicalmani\Task\Storage\TaskExecutionRepositoryInterface;
use Clicalmani\Task\TaskInterface;
use Clicalmani\Task\TaskStatus;

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
    public function create(TaskInterface $task, \DateTime $scheduleTime) : TaskExecutionInterface
    {
        return new TaskExecution($task, $task->getHandlerClass(), $scheduleTime, $task->getWorkload());
    }

    /**
     * {@inheritdoc}
     */
    public function save(TaskExecutionInterface $execution) : self
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
    public function remove(TaskExecutionInterface $execution) : self
    {
        $this->taskExecutionCollection->remove($execution);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush() : self
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function findPending(TaskInterface $task) : ?TaskExecutionInterface
    {
        $filtered = $this->taskExecutionCollection->filter(
            function (TaskExecutionInterface $execution) use ($task) {
                return $execution->getTask()->getUuid() === $task->getUuid()
                    && in_array($execution->getStatus(), [TaskStatus::PLANNED, TaskStatus::RUNNING]);
            }
        );

        if (0 === $filtered->count()) {
            return null;
        }

        return $filtered->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByUuid(string $uuid) : ?TaskExecutionInterface
    {
        $filtered = $this->taskExecutionCollection->filter(
            function (TaskExecutionInterface $execution) use ($uuid) {
                return $execution->getUuid() === $uuid;
            }
        );

        if (0 === $filtered->count()) {
            return null;
        }

        return $filtered->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByTask(TaskInterface $task) : array
    {
        return $this->findByTaskUuid($task->getUuid());
    }

    /**
     * {@inheritdoc}
     */
    public function findByTaskUuid(string $taskUuid) : array
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
    public function findAll(int $page = 1, ?int $pageSize = null) : array
    {
        if (null === $pageSize) {
            return $this->taskExecutionCollection->toArray();
        }

        if ($page < 1) {
            $page = 1;
        }

        if ($pageSize < 1) {
            $pageSize = 10; // Default page size
        }

        if ($page > ceil($this->taskExecutionCollection->count() / $pageSize)) {
            return [];
        }

        return array_values($this->taskExecutionCollection->slice(($page - 1) * $pageSize, $pageSize));
    }

    /**
     * {@inheritdoc}
     */
    public function findNextScheduled(?\DateTime $dateTime = null, array $skippedExecutions = []) : ?TaskExecutionInterface
    {
        $dateTime = $dateTime ?: new \DateTime();
        
        $result = $this->taskExecutionCollection->filter(
            function (TaskExecutionInterface $execution) use ($dateTime, $skippedExecutions) {
                return $execution->getStatus()->isPlanned()
                    && $execution->getTask()->getInterval()->isDue()
                    && !in_array($execution->getUuid(), $skippedExecutions);
            }
        )->first();
        
        return $result ?: null;
    }
}
