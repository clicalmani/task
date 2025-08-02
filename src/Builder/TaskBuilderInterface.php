<?php

/**
 * Task builder interface for creating and scheduling tasks.
 *
 * This interface defines methods to build tasks with various scheduling options.
 * It provides methods to create task builders with different intervals such as hourly, daily, weekly,
 * monthly, and yearly, as well as custom cron expressions.
 *
 * @package Clicalmani\Task\Builder
 * @since 1.0.0
 */
namespace Clicalmani\Task\Builder;

use Clicalmani\Task\TaskInterface;

interface TaskBuilderInterface
{
    /**
     * Use hourly interval.
     *
     * @param \DateTime $firstExecution
     * @param \DateTime $lastExecution
     *
     * @return self
     */
    public function hourly(?\DateTime $firstExecution = null, ?\DateTime $lastExecution = null) : self;

    /**
     * Use daily interval.
     *
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return self
     */
    public function daily(?\DateTime $start = null, ?\DateTime $end = null) : self;

    /**
     * Use weekly interval.
     *
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return self
     */
    public function weekly(?\DateTime $start = null, ?\DateTime $end = null) : self;

    /**
     * Use monthly interval.
     *
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return self
     */
    public function monthly(?\DateTime $start = null, ?\DateTime $end = null) : self;

    /**
     * Use yearly interval.
     *
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return self
     */
    public function yearly(?\DateTime $start = null, ?\DateTime $end = null) : self;

    /**
     * Use given cron-interval.
     *
     * @param string $cronExpression
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return self
     */
    public function cron(string $cronExpression, ?\DateTime $start = null, ?\DateTime $end = null) : self;

    /**
     * Set execution-date.
     *
     * @param \DateTime $executionDate
     *
     * @return self
     */
    public function executeAt(\DateTime $executionDate) : self;

    /**
     * Schedules built task and returns it.
     *
     * @return TaskInterface
     */
    public function schedule() : TaskInterface;
}
