<?php


/**
 * Base exception for lock-conflicts.
 *
 * This exception is thrown when there is a conflict in acquiring a lock.
 *
 * @package Clicalmani\Task\Lock\Exception
 * @since 1.0.0
 */
namespace Clicalmani\Task\Lock\Exception;

abstract class LockConflictException extends \Exception
{
    /**
     * @var string
     */
    private $key;

    /**
     * @param string $key
     * @param string $message
     */
    public function __construct(string $key, string $message)
    {
        parent::__construct($message);
        $this->key = $key;
    }

    /**
     * Returns key.
     *
     * @return string
     */
    public function getKey() : string
    {
        return $this->key;
    }
}
