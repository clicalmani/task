<?php

/**
 * Lock already acquired exception.
 *
 * This exception is thrown when an attempt is made to acquire a lock that is already held.
 *
 * @package Clicalmani\Task\Lock\Exception
 * @since 1.0.0
 */
namespace Clicalmani\Task\Lock\Exception;

class LockAlreadyAcquiredException extends LockConflictException
{
    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct($key, sprintf('Lock for key "%s" is already acquired.', $key));
    }
}
