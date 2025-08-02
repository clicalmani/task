<?php

/**
 * Task runner interface.
 *
 * This interface defines the contract for running scheduled tasks.
 *
 * @package Clicalmani\Task\Runner
 * @since 1.0.0
 */
namespace Clicalmani\Task\Runner;

/**
 * Interface for task-runner.
 */
interface TaskRunnerInterface
{
    /**
     * Run scheduled tasks.
     */
    public function runTasks();
}
