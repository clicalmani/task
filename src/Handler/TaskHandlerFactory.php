<?php

/**
 * Task handler factory.
 *
 * Allows to add handler instances to run tasks.
 *
 * This factory is responsible for creating instances of task handlers.
 * It checks if the class exists before instantiation and throws an exception if it does not.
 *
 * @package Clicalmani\Task\Handler
 * @since 1.0.0
 */
namespace Clicalmani\Task\Handler;

class TaskHandlerFactory implements TaskHandlerFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(string $className) : TaskHandlerInterface
    {
        if (!class_exists($className)) {
            throw new TaskHandlerNotExistsException($className);
        }
        
        return new $className();
    }
}
