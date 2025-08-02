<?php

/**
 * Internal exception to indicate a retry for given exception.
 * 
 * This exception is thrown when a task execution fails and the handler supports retrying.
 * It contains the maximum number of attempts allowed for the retry.
 * 
 * @package Clicalmani\Task\Executor
 * @since 1.0.0
 */
namespace Clicalmani\Task\Executor;

class RetryException extends \Exception
{
    /**
     * @var int
     */
    private $maximumAttempts;

    /**
     * @param int $maximumAttempts
     * @param \Exception $previous
     */
    public function __construct($maximumAttempts, \Exception $previous)
    {
        parent::__construct($previous->getMessage(), $previous->getCode(), $previous);

        $this->maximumAttempts = $maximumAttempts;
    }

    /**
     * Returns maximum-attempts.
     *
     * @return int
     */
    public function getMaximumAttempts()
    {
        return $this->maximumAttempts;
    }
}
