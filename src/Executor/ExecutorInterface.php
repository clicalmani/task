<?php

/**
 * Interface for task-executor.
 *
 * This interface defines the contract for executing tasks.
 * Implementations of this interface should handle the execution logic
 * for tasks, including error handling and retry mechanisms.
 *
 * @package Clicalmani\Task\Executor
 * @since 1.0.0
 */
namespace Clicalmani\Task\Executor;

use Clicalmani\Task\Execution\TaskExecutionInterface;

interface ExecutorInterface
{
    /**
     * Executes given task.
     *
     * @param TaskExecutionInterface $execution
     * @return mixed
     * @throws RetryException indicates that the current run should by retried
     * @throws FailedException indicates that the current run was failed
     */
    public function execute(TaskExecutionInterface $execution);
}
