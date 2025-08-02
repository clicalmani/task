<?php

/**
 * Finder for executions.
 *
 * This interface defines a method to find task executions.
 *
 * @package Clicalmani\Task\Runner
 * @since 1.0.0
 */
namespace Clicalmani\Task\Runner;

use Clicalmani\Task\Execution\TaskExecutionInterface;

interface ExecutionFinderInterface
{
    /**
     * Returns list of executions.
     *
     * @return TaskExecutionInterface[]
     */
    public function find() : \Generator;
}
