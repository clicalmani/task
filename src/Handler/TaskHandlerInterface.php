<?php

/**
 * Task handler interface.
 *
 * This interface defines the contract for task handlers that can process workloads.
 * Implementations of this interface should provide the logic to handle the given workload
 * and return the result of the processing.
 *
 * @package Clicalmani\Task\Handler
 * @since 1.0.0
 */
namespace Clicalmani\Task\Handler;

use Clicalmani\Task\Messenger\MessageInterface;

interface TaskHandlerInterface
{
    /**
     * Handles the given message.
     *
     * @param object $message The message to handle.
     * @return void
     */
    public function __invoke(MessageInterface $message) : void;
}

