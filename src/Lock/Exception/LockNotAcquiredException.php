<?php

/**
 * Will be thrown when the lock was not already acquired.
 *
 * This exception is thrown when an attempt is made to release a lock that was never acquired.
 *
 * @package Clicalmani\Task\Lock\Exception
 * @since 1.0.0
 */
namespace Clicalmani\Task\Lock\Exception;

class LockNotAcquiredException extends LockConflictException
{
    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct($key, sprintf('Lock for key "%s" is already not acquired.', $key));
    }
}
