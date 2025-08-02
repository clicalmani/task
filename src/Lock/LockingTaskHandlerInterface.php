<?php

/**
 * Locking task handler interface.
 *
 * This interface extends the TaskHandlerInterface to provide locking capabilities
 * for task handlers. Implementations of this interface should define how to lock
 * resources during task execution.
 *
 * @package Clicalmani\Task\Lock
 * @since 1.0.0
 */
namespace Clicalmani\Task\Lock;

use Clicalmani\Task\Handler\TaskHandlerInterface;

interface LockingTaskHandlerInterface extends TaskHandlerInterface
{
    /**
     * Returns lock-key which defines the locked resources.
     *
     * @param string|\Serializable $workload
     * @return string
     */
    public function getLockKey(string|\Serializable $workload) : string;
}
