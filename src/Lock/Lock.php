<?php

/**
 * Lock management interface.
 *
 * This interface defines methods for acquiring, releasing, and checking locks.
 * It is used to manage locks in a distributed system to
 * ensure that only one process can access a resource at a time.
 * Implementations of this interface should provide the logic for handling locks,
 * including storage and retrieval of lock states.
 * 
 * @package Clicalmani\Task\Lock
 * @since 1.0.0
 */
namespace Clicalmani\Task\Lock;

use Clicalmani\Task\Lock\Exception\LockAlreadyAcquiredException;
use Clicalmani\Task\Lock\Exception\LockNotAcquiredException;

class Lock implements LockInterface
{
    /**
     * @var LockStorageInterface
     */
    private $storage;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @param LockStorageInterface $storage
     * @param int $ttl
     */
    public function __construct(LockStorageInterface $storage, $ttl = 300)
    {
        $this->storage = $storage;
        $this->ttl = $ttl;
    }

    /**
     * {@inheritdoc}
     */
    public function acquire(string $key) : bool
    {
        $this->assertNotAcquired($key);

        return $this->storage->save($key, $this->ttl);
    }

    /**
     * {@inheritdoc}
     */
    public function refresh(string $key) : bool
    {
        $this->assertAcquired($key);

        return $this->storage->save($key, $this->ttl);
    }

    /**
     * {@inheritdoc}
     */
    public function release(string $key) : bool
    {
        $this->assertAcquired($key);

        return $this->storage->delete($key);
    }

    /**
     * {@inheritdoc}
     */
    public function isAcquired(string $key) : bool
    {
        return $this->storage->exists($key);
    }

    /**
     * Throw exception if the given key is not acquired.
     *
     * @param string $key
     * @throws LockNotAcquiredException
     */
    private function assertAcquired(string $key)
    {
        if ($this->isAcquired($key)) {
            return;
        }

        throw new LockNotAcquiredException($key);
    }

    /**
     * Throw exception if the given key is acquired.
     *
     * @param string $key
     * @throws LockAlreadyAcquiredException
     */
    private function assertNotAcquired(string $key)
    {
        if (!$this->isAcquired($key)) {
            return;
        }

        throw new LockAlreadyAcquiredException($key);
    }
}
