<?php

/**
 * Task Builder for creating and scheduling tasks.
 *
 * This class provides methods to build tasks with various scheduling options
 * such as hourly, daily, weekly, monthly, yearly, or custom cron expressions.
 *
 * @package Clicalmani\Task\Builder
 * @since 1.0.0
 */
namespace Clicalmani\Task\Builder;

use Cron\CronExpression;
use Clicalmani\Task\Scheduler\TaskSchedulerInterface;
use Clicalmani\Task\TaskInterface;

class TaskBuilder implements TaskBuilderInterface
{
    /**
     * @var TaskInterface
     */
    protected $task;

    /**
     * @var TaskSchedulerInterface
     */
    protected $taskScheduler;

    /**
     * @param TaskInterface $task
     * @param TaskSchedulerInterface $taskScheduler
     */
    public function __construct(TaskInterface $task, TaskSchedulerInterface $taskScheduler)
    {
        $this->task = $task;
        $this->taskScheduler = $taskScheduler;
    }

    /**
     * {@inheritdoc}
     */
    public function cron(string $cronExpression, ?\DateTime $firstExecution = null, ?\DateTime $lastExecution = null) : self
    {
        $this->task->setInterval(new CronExpression($cronExpression), $firstExecution, $lastExecution);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function schedule() : TaskInterface
    {
        $this->taskScheduler->addTask($this->task);
        return $this->task;
    }
}
