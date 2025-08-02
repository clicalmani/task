<?php

/**
 * Lock interface.
 *
 * This interface defines the contract for a lock mechanism that can be used to
 * acquire, refresh, release, and check the status of locks based on a key.
 *
 * @package Clicalmani\Task\Lock
 * @since 1.0.0
 */
namespace Clicalmani\Task\Lock;

use Clicalmani\Task\Lock\Exception\LockAlreadyAcquiredException;
use Clicalmani\Task\Lock\Exception\LockNotAcquiredException;

interface LockInterface
{
    /**
     * Acquires the lock of given key.
     * If the lock is already acquired an exception will be raised.
     *
     * @param string $key
     * @return bool
     * @throws LockAlreadyAcquiredException
     */
    public function acquire(string $key) : bool;

    /**
     * Increase the duration of an acquired lock for given key.
     * If the lock is not acquired an exception will be raised.
     *
     * @param string $key
     * @return bool
     * @throws LockNotAcquiredException
     */
    public function refresh(string $key) : bool;

    /**
     * Release the lock for given key.
     *
     * @param string $key
     * @return bool
     * @throws LockNotAcquiredException
     */
    public function release(string $key) : bool;

    /**
     * Returns whether or not the lock for given key is acquired.
     *
     * @param string $key
     * @return bool
     */
    public function isAcquired(string $key) : bool;
}
