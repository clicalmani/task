<?php

/**
 * Lock storage interface.
 *
 * This interface defines the contract for lock storage implementations.
 * It provides methods to save, delete, and check the existence of locks.
 *
 * @package Clicalmani\Task\Lock
 * @since 1.0.0
 */
namespace Clicalmani\Task\Lock\Storage;

use Clicalmani\Task\Lock\LockStorageInterface;

class FileLockStorage implements LockStorageInterface
{
    /**
     * @param string $lockPath
     */
    public function __construct(private string $lockPath)
    {
        if (!is_dir($this->lockPath)) {
            mkdir($this->lockPath, 0777, true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save(string $key, int $ttl) : bool
    {
        $fileName = $this->getFileName($key);
        if (!@file_put_contents($fileName, time() + $ttl)) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $key) : bool
    {
        $fileName = $this->getFileName($key);
        if (!file_exists($fileName)) {
            return true;
        }

        if (!@unlink($fileName)) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function exists(string $key) : bool
    {
        $fileName = $this->getFileName($key);
        if (!file_exists($fileName)) {
            return false;
        }

        $content = file_get_contents($fileName);

        return time() <= $content;
    }

    /**
     * {@inheritdoc}
     */
    private function getFileName(string $key) : string
    {
        return $this->lockPath . DIRECTORY_SEPARATOR . preg_replace('/[^a-zA-Z0-9]/', '_', $key) . '.lock';
    }
}
