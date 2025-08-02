<?php

/**
 * Task interface.
 *
 * This interface defines the structure for a task, including methods to get task details
 * such as UUID, handler class, workload, interval, and execution times.
 *
 * @package Clicalmani\Task
 * @since 1.0.0
 */
namespace Clicalmani\Task;

use Cron\CronExpression;

interface TaskInterface
{
    /**
     * Returns uuid.
     *
     * @return string
     */
    public function getUuid() : string;

    /**
     * Returns task-name.
     *
     * @return string
     */
    public function getHandlerClass() : string;

    /**
     * Returns workload.
     *
     * @return ?object
     */
    public function getWorkload() : ?object;

    /**
     * Returns interval.
     *
     * @return CronExpression
     */
    public function getInterval() : CronExpression;

    /**
     * Returns first-execution date-time.
     *
     * @return \DateTime
     */
    public function getFirstExecution() : \DateTime;

    /**
     * Set first-execution.
     *
     * @param \DateTime $firstExecution
     * @return self
     */
    public function setFirstExecution(\DateTime $firstExecution) : self;

    /**
     * Returns first-execution date-time.
     *
     * @return \DateTime
     */
    public function getLastExecution() : \DateTime;

    /**
     * Set interval.
     *
     * @param CronExpression $interval
     * @param \DateTime $firstExecution null means for "now"
     * @param \DateTime $lastExecution null means forever
     * @return self
     */
    public function setInterval(CronExpression $interval, ?\DateTime $firstExecution = null, ?\DateTime $lastExecution = null) : self;
}
