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

use Symfony\Component\Uid\Uuid;
use Clicalmani\Task\TaskInterface;
use Clicalmani\Task\TaskStatus;

class TaskExecution implements TaskExecutionInterface
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var TaskInterface
     */
    protected $task;

    /**
     * @var \Serializable|string
     */
    protected $workload;

    /**
     * @var string
     */
    protected $handlerClass;

    /**
     * @var \DateTime
     */
    protected $scheduleTime;

    /**
     * @var \DateTime
     */
    protected $startTime;

    /**
     * @var \DateTime
     */
    protected $endTime;

    /**
     * @var float
     */
    protected $duration;

    /**
     * @var TaskStatus
     */
    protected $status;

    /**
     * @var string|\Serializable
     */
    protected $result;

    /**
     * @var string
     */
    protected $exception;

    /**
     * @var int
     */
    protected $attempts = 1;

    /**
     * @param TaskInterface $task
     * @param $handlerClass
     * @param \DateTime $scheduleTime
     * @param string|\Serializable $workload
     * @param string $uuid
     */
    public function __construct(
        TaskInterface $task,
        $handlerClass,
        \DateTime $scheduleTime,
        $workload = null,
        $uuid = null
    ) {
        $this->uuid = $uuid ?: Uuid::v4()->toRfc4122();
        $this->task = $task;
        $this->handlerClass = $handlerClass;
        $this->scheduleTime = $scheduleTime;
        $this->workload = $workload;
    }

    /**
     * {@inheritdoc}
     */
    public function getUuid() : string
    {
        return $this->uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function getTask() : TaskInterface
    {
        return $this->task;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkload() : object
    {
        return $this->workload;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlerClass() : string
    {
        return $this->handlerClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduleTime() : \DateTime
    {
        return $this->scheduleTime;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartTime(\DateTime $startTime) : self
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndTime(\DateTime $endTime) : self
    {
        if ($endTime < $this->startTime) {
            throw new \InvalidArgumentException('End time cannot be earlier than start time.');
        }

        $this->endTime = $endTime;
        $this->duration = $this->startTime ? $this->endTime->getTimestamp() - $this->startTime->getTimestamp() : 0;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDuration($duration) : self
    {
        if (!is_numeric($duration) || $duration < 0) {
            throw new \InvalidArgumentException('Duration must be a non-negative number.');
        }
        
        // If start and end times are set, recalculate duration
        if ($this->startTime && $this->endTime) {
            $this->duration = $this->endTime->getTimestamp() - $this->startTime->getTimestamp();
        } else {
            $this->duration = $duration;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartTime() : \DateTime
    {
        return $this->startTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndTime() : \DateTime
    {
        return $this->endTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getDuration() : float
    {
        return $this->duration;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus() : TaskStatus
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult() : \Serializable|string
    {
        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function getException()  : string
    {
        return $this->exception;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(TaskStatus $status) : self
    {
        if (!$status->isValid($status)) {
            throw new \InvalidArgumentException('Invalid task status provided.');
        }
        
        $this->status = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setResult(string|\Serializable|null $result) : self
    {
        if (!is_string($result) && !($result instanceof \Serializable)) {
            throw new \InvalidArgumentException('Result must be a string or an instance of Serializable.');
        }
        
        // If result is null, we can set it to null
        if ($result === null) {
            $this->result = null;
            return $this;
        }

        // Otherwise, we set the result
        $this->result = $result;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setException(string $exception) : self
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttempts() : int
    {
        return $this->attempts;
    }

    /**
     * {@inheritdoc}
     */
    public function reset() : self
    {
        $this->startTime = null;
        $this->endTime = null;
        $this->result = null;
        $this->exception = null;
        $this->status = TaskStatus::PLANNED;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function incrementAttempts() : self
    {
        ++$this->attempts;

        return $this;
    }
}
