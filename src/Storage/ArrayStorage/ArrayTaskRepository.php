<?php

/**
 * Task execution repository for managing task executions in an array.
 *
 * This class implements the TaskExecutionRepositoryInterface and provides methods to create, save,
 * remove, and find task executions based on various criteria.
 *
 * @package Clicalmani\Task\Storage\ArrayStorage
 * @since 1.0.0
 */
namespace Clicalmani\Task\Storage\ArrayStorage;

use Clicalmani\Foundation\Collection\Collection;
use Clicalmani\Foundation\Collection\CollectionInterface;
use Clicalmani\Task\Storage\TaskRepositoryInterface;
use Clicalmani\Task\Task;
use Clicalmani\Task\TaskInterface;

class ArrayTaskRepository implements TaskRepositoryInterface
{
    /**
     * @var \Clicalmani\Foundation\Collection\CollectionInterface
     */
    private $taskCollection;

    /**
     * @param \Clicalmani\Foundation\Collection\CollectionInterface $tasks
     */
    public function __construct(?CollectionInterface $tasks = null)
    {
        $this->taskCollection = $tasks ?: new Collection();
    }

    /**
     * {@inheritdoc}
     */
    public function findByUuid(string $uuid) : ?TaskInterface
    {
        /** @var TaskInterface $task */
        foreach ($this->taskCollection as $task) {
            if ($task->getUuid() === $uuid) {
                return $task;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $handlerClass, ?object $workload = null) : TaskInterface
    {
        return new Task($handlerClass, $workload);
    }

    /**
     * {@inheritdoc}
     */
    public function save(TaskInterface $task) : static
    {
        if ($this->taskCollection->contains($task)) {
            return $this;
        }

        $this->taskCollection->add($task);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(TaskInterface $task) : static
    {
        $this->taskCollection->remove($task);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush() : static
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($page = 1, $pageSize = null) : iterable
    {
        return array_values($this->taskCollection->slice(($page - 1) * $pageSize, $pageSize));
    }

    /**
     * {@inheritdoc}
     */
    public function findEndBeforeNow() : iterable
    {
        $now = new \DateTime();

        return array_values(
            $this->taskCollection->filter(
                function (TaskInterface $task) use ($now) {
                    return null === $task->getLastExecution() || $task->getLastExecution() > $now;
                }
            )->toArray()
        );
    }
}
