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
    public function hourly(?\DateTime $firstExecution = null, ?\DateTime $lastExecution = null) : self
    {
        $this->task->setInterval(CronExpression::factory('@hourly'), $firstExecution, $lastExecution);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function daily(?\DateTime $firstExecution = null, ?\DateTime $lastExecution = null) : self
    {
        $this->task->setInterval(CronExpression::factory('@daily'), $firstExecution, $lastExecution);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function weekly(?\DateTime $firstExecution = null, ?\DateTime $lastExecution = null) : self
    {
        $this->task->setInterval(CronExpression::factory('@weekly'), $firstExecution, $lastExecution);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function monthly(?\DateTime $firstExecution = null, ?\DateTime $lastExecution = null) : self
    {
        $this->task->setInterval(CronExpression::factory('@monthly'), $firstExecution, $lastExecution);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function yearly(?\DateTime $firstExecution = null, ?\DateTime $lastExecution = null) : self
    {
        $this->task->setInterval(CronExpression::factory('@yearly'), $firstExecution, $lastExecution);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function cron(string $cronExpression, ?\DateTime $firstExecution = null, ?\DateTime $lastExecution = null) : self
    {
        $this->task->setInterval(CronExpression::factory($cronExpression), $firstExecution, $lastExecution);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function executeAt(\DateTime $executionDate) : self
    {
        $this->task->setFirstExecution($executionDate);

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
