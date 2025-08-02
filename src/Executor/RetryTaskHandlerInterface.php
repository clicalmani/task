<?php

/**
 * Indicates that this handler can be retried.
 * 
 * This interface is used to define a retry task handler that can handle task execution failures
 * and allows for retrying the task execution a specified number of times.
 * Implementations of this interface should provide the logic for determining the maximum number of attempts
 * allowed for retrying a task.
 * 
 * @package Clicalmani\Task\Executor
 * @since 1.0.0
 */
namespace Clicalmani\Task\Executor;

interface RetryTaskHandlerInterface
{
    /**
     * Returns maximum attempts to pass tasks with this handler.
     *
     * @return int
     */
    public function getMaximumAttempts();
}
