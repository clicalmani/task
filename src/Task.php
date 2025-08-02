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
namespace Clicalmani\Task;

use Cron\CronExpression;
use Symfony\Component\Uid\Uuid;

class Task implements TaskInterface
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $handlerClass;

    /**
     * @var string|\Serializable
     */
    protected $workload;

    /**
     * @var CronExpression
     */
    protected $interval;

    /**
     * @var \DateTime
     */
    protected $firstExecution;

    /**
     * @var \DateTime
     */
    protected $lastExecution;

    /**
     * @param string $handlerClass
     * @param ?object $workload
     * @param string $uuid
     */
    public function __construct(string $handlerClass, ?object $workload = null, ?string $uuid = null)
    {
        $this->uuid = $uuid ?: Uuid::v4()->toRfc4122();
        $this->handlerClass = $handlerClass;
        $this->workload = $workload;

        $this->firstExecution = new \DateTime();
        $this->lastExecution = new \DateTime();
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
    public function getHandlerClass() : string
    {
        return $this->handlerClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkload() : ?object
    {
        return $this->workload;
    }

    /**
     * {@inheritdoc}
     */
    public function getInterval() : CronExpression
    {
        return $this->interval;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstExecution() : \DateTime
    {
        return $this->firstExecution;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstExecution(\DateTime $firstExecution) : self
    {
        $this->firstExecution = $firstExecution;
        $this->lastExecution = null;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastExecution() : \DateTime
    {
        return $this->lastExecution;
    }

    /**
     * {@inheritdoc}
     */
    public function setInterval(
        CronExpression $interval,
        ?\DateTime $firstExecution = null,
        ?\DateTime $lastExecution = null
    ) : self {
        $this->interval = $interval;
        $this->firstExecution = $firstExecution ?: new \DateTime();
        $this->lastExecution = $lastExecution;

        return $this;
    }
}
