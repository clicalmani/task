<?php

/**
 * Thrown when the requested handler not exists.
 *
 * This exception is thrown when a task handler cannot be found for the specified class name.
 * It provides information about the class name that was attempted to be instantiated.
 *
 * @package Clicalmani\Task\Handler
 * @since 1.0.0
 */
namespace Clicalmani\Task\Handler;

class TaskHandlerNotExistsException extends \Exception
{
    /**
     * @var string
     */
    private $className;

    /**
     * @param string $className
     */
    public function __construct(string $className)
    {
        parent::__construct(sprintf('Handler with name "%s" not exists.', $className));

        $this->className = $className;
    }

    /**
     * Returns name of requested handler.
     *
     * @return string
     */
    public function getClassName() : string
    {
        return $this->className;
    }
}
