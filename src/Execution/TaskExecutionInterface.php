<?php

/**
 * Task Execution Interface for defining the structure of task execution.
 *
 * This interface outlines the methods required for executing a task, including
 * handling the task's workload, scheduling, and managing execution state.
 *
 * @package Clicalmani\Task\Execution
 * @since 1.0.0
 */
namespace Clicalmani\Task\Execution;

use Clicalmani\Queue\Task;
use Clicalmani\Task\TaskInterface;
use Clicalmani\Task\TaskStatus;

interface TaskExecutionInterface
{
    /**
     * Returns uuid.
     *
     * @return string
     */
    public function getUuid() : string;

    /**
     * Returns task.
     *
     * @return TaskInterface
     */
    public function getTask() : TaskInterface;

    /**
     * Returns workload.
     *
     * @return object
     */
    public function getWorkload() : object;

    /**
     * Returns handler-class.
     *
     * @return string
     */
    public function getHandlerClass() : string;

    /**
     * Returns schedule-time.
     *
     * @return \DateTime
     */
    public function getScheduleTime() : \DateTime;

    /**
     * Returns start-time.
     *
     * @return \DateTime
     */
    public function getStartTime() : \DateTime;

    /**
     * Returns end-time.
     *
     * @return \DateTime
     */
    public function getEndTime() : \DateTime;

    /**
     * Returns duration.
     *
     * @return float
     */
    public function getDuration() : float;

    /**
     * Returns status.
     *
     * @return TaskStatus
     */
    public function getStatus() : TaskStatus;

    /**
     * Returns result.
     *
     * @return \Serializable|string
     */
    public function getResult() : \Serializable|string;

    /**
     * Returns exception.
     *
     * @return string
     */
    public function getException() : string;

    /**
     * Set status.
     *
     * @param TaskStatus $status
     * @return self
     */
    public function setStatus(TaskStatus $status) : self;

    /**
     * Set result.
     *
     * @param string|\Serializable|null $result
     * @return self
     */
    public function setResult(string|\Serializable|null $result) : self;

    /**
     * Set exception.
     *
     * @param string $exception
     * @return self
     */
    public function setException(string $exception) : self;

    /**
     * Set start-time.
     *
     * @param \DateTime $startTime
     * @return self
     */
    public function setStartTime(\DateTime $startTime) : self;

    /**
     * Set end-time.
     *
     * @param \DateTime $endTime
     * @return self
     */
    public function setEndTime(\DateTime $endTime) : self;

    /**
     * Set duration.
     *
     * @param float $duration
     * @return self
     */
    public function setDuration(float $duration) : self;

    /**
     * Returns amount of attempts to pass this execution.
     *
     * @return int
     */
    public function getAttempts() : int;

    /**
     * Reset execution to retry after failed run.
     *
     * @return self
     */
    public function reset() : self;

    /**
     * Increments amount of attempts to pass this execution.
     *
     * @return self
     */
    public function incrementAttempts() : self;
}
