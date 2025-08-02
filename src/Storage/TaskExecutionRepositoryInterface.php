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
namespace Clicalmani\Task\Storage;

use Clicalmani\Task\Execution\TaskExecutionInterface;
use Clicalmani\Task\TaskInterface;

interface TaskExecutionRepositoryInterface
{
    /**
     * Create task-execution.
     *
     * @param TaskInterface $task
     * @param \DateTime $scheduleTime
     * @return TaskExecutionInterface
     */
    public function create(TaskInterface $task, \DateTime $scheduleTime) : TaskExecutionInterface;

    /**
     * Save task-execution.
     *
     * @param TaskExecutionInterface $execution
     * @return self
     */
    public function save(TaskExecutionInterface $execution) : self;

    /**
     * Remove task-execution.
     *
     * @param TaskExecutionInterface $execution
     * @return self
     */
    public function remove(TaskExecutionInterface $execution) : self;

    /**
     * Used to check whether a specific task has been scheduled at a specific time.
     *
     * @param TaskInterface $task
     * @return ?TaskExecutionInterface
     */
    public function findPending(TaskInterface $task) : ?TaskExecutionInterface;

    /**
     * Returns task-execution identified by uuid.
     *
     * @param string $uuid
     * @return ?TaskExecutionInterface
     */
    public function findByUuid(string $uuid) : ?TaskExecutionInterface;

    /**
     * Find executions of given task.
     *
     * @param TaskInterface $task
     * @return TaskExecutionInterface[]
     */
    public function findByTask(TaskInterface $task) : array;

    /**
     * Find executions of given task.
     *
     * @param string $taskUuid
     * @return TaskExecutionInterface[]
     */
    public function findByTaskUuid(string $taskUuid) : array;

    /**
     * Returns all task-executions.
     *
     * @param int $page
     * @param int $pageSize
     * @return TaskExecutionInterface[]
     */
    public function findAll(int $page = 1, ?int $pageSize = null) : array;

    /**
     * Returns scheduled task-execution.
     *
     * Scheduled-time in the past relative to given date.
     *
     * @param ?\DateTime $dateTime
     * @param array $skippedExecutions
     * @return ?TaskExecutionInterface
     */
    public function findNextScheduled(?\DateTime $dateTime = null, array $skippedExecutions = []) : ?TaskExecutionInterface;
}
