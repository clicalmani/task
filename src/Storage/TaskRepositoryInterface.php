<?php

/**
 * Task repository interface.
 *
 * This interface defines methods for managing tasks, including creating, saving, removing,
 * and finding tasks based on various criteria.
 *
 * @package Clicalmani\Task\Storage
 * @since 1.0.0
 */
namespace Clicalmani\Task\Storage;

use Clicalmani\Task\TaskInterface;

interface TaskRepositoryInterface
{
    /**
     * Find task for given uuid.
     *
     * @param string $uuid
     * @return ?TaskInterface
     */
    public function findByUuid(string $uuid) : ?TaskInterface;

    /**
     * Create task.
     *
     * @param string $handlerClass
     * @param ?object $workload
     * @return TaskInterface
     */
    public function create(string $handlerClass, ?object $workload = null) : TaskInterface;

    /**
     * Save task.
     *
     * @param TaskInterface $task
     * @return self
     */
    public function save(TaskInterface $task) : self;

    /**
     * Remove task.
     *
     * @param TaskInterface $task
     * @return self
     */
    public function remove(TaskInterface $task) : self;

    /**
     * Returns all tasks.
     *
     * @param int $page
     * @param int $pageSize
     * @return TaskInterface[]
     */
    public function findAll(int $page = 1, ?int $pageSize = null) : iterable;

    /**
     * Used to find tasks which has end-date before now.
     *
     * @return TaskInterface[]
     */
    public function findEndBeforeNow() : iterable;
}
