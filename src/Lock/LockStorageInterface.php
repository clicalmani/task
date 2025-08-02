<?php

/**
 * Lock storage interface.
 *
 * This interface defines the contract for a lock storage mechanism that can be used
 * to save, delete, and check the existence of locks based on a key.
 *
 * @package Clicalmani\Task\Lock
 * @since 1.0.0
 */
namespace Clicalmani\Task\Lock;

interface LockStorageInterface
{
    /**
     * Stores the lock.
     * If the lock already exists the ttl will be increased.
     *
     * @param string $key
     * @param int $ttl
     * @return bool
     */
    public function save(string $key, int $ttl) : bool;

    /**
     * Deletes the lock.
     * If the lock does not exist it will return false.
     *
     * @param string $key
     * @return bool
     */
    public function delete(string $key) : bool;

    /**
     * Checks if the lock exists.
     *
     * @param string $key
     * @return bool
     */
    public function exists(string $key) : bool;
}
