<?php

/*
 * This file is part of php-task library.
 *
 * (c) php-task
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Clicalmani\Task\Storage;

use Clicalmani\Task\TaskInterface;

/**
 * Interface for task repository.
 */
interface TaskRepositoryInterface
{
    /**
     * Find task for given uuid.
     *
     * @param string $uuid
     *
     * @return ?\Clicalmani\Task\TaskInterface
     */
    public function findByUuid($uuid) : ?TaskInterface;

    /**
     * Create task.
     *
     * @param string $handlerClass
     * @param ?object $workload
     *
     * @return \Clicalmani\Task\TaskInterface
     */
    public function create(string $handlerClass, ?object $workload = null) : TaskInterface;

    /**
     * Save task.
     *
     * @param \Clicalmani\Task\TaskInterface $task
     * @return self
     */
    public function save(TaskInterface $task) : self;

    /**
     * Remove task.
     *
     * @param \Clicalmani\Task\TaskInterface $task
     * @return self
     */
    public function remove(TaskInterface $task) : self;

    /**
     * Returns all tasks.
     *
     * @param int $page
     * @param int $pageSize
     *
     * @return \Clicalmani\Task\TaskInterface[]
     */
    public function findAll(int $page = 1, ?int $pageSize = null) : iterable;

    /**
     * Used to find tasks which has end-date before now.
     *
     * @return \Clicalmani\Task\TaskInterface[]
     */
    public function findEndBeforeNow() : iterable;
}
