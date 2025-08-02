<?php

/**
 * Interface for task-handler factory.
 *
 * This interface defines a method to create task handlers based on their class name.
 * It is used to instantiate task handlers dynamically, ensuring that the class exists before instantiation.
 *
 * @package Clicalmani\Task\Handler
 * @since 1.0.0
 */
namespace Clicalmani\Task\Handler;

interface TaskHandlerFactoryInterface
{
    /**
     * Returns task-handle for given class-name.
     *
     * @param string $className
     *
     * @return TaskHandlerInterface
     *
     * @throws TaskHandlerNotExistsException
     */
    public function create(string $className) : TaskHandlerInterface;
}
