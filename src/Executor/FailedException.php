<?php

/**
 * Will be thrown by RetryTaskHandler to indicate that the current run was failed and should not be retried.
 *
 * This exception is used to signal that the task execution has failed and no further attempts should be made.
 * It is typically thrown when the task cannot be completed due to an unrecoverable error.
 * Implementations of the ExecutorInterface should catch this exception to handle task failures appropriately.
 *
 * @package Clicalmani\Task\Executor
 * @since 1.0.0
 */
namespace Clicalmani\Task\Executor;

class FailedException extends \Exception
{
    public function __construct(\Exception $previous)
    {
        parent::__construct($previous->getMessage(), $previous->getCode(), $previous);
    }
}
