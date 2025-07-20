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
use Clicalmani\Task\Storage\TaskRepositoryInterface;
use Clicalmani\Task\Task;
use Clicalmani\Task\TaskInterface;

/**
 * Storage task in an array.
 */
class ArrayTaskRepository implements TaskRepositoryInterface
{
    /**
     * @var Collection
     */
    private $taskCollection;

    /**
     * @param Collection $tasks
     */
    public function __construct(?Collection $tasks = null)
    {
        $this->taskCollection = $tasks ?: new Collection();
    }

    /**
     * {@inheritdoc}
     */
    public function findByUuid($uuid) : ?TaskInterface
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
    public function create(string $handlerClass, string|\Serializable|null $workload = null) : TaskInterface
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
