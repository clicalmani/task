<?php

/**
 * Task Status Enum for defining the possible states of a task.
 *
 * This enum outlines the various statuses a task can have during its lifecycle,
 * including planned, running, completed, aborted, and failed.
 *
 * @package Clicalmani\Task
 * @since 1.0.0
 */
namespace Clicalmani\Task;

Enum TaskStatus
{
    case PLANNED;
    case RUNNING;
    case COMPLETED;
    case ABORTED;
    case FAILED;

    public static function isValid(self $status): bool
    {
        return in_array($status, [
            self::PLANNED,
            self::RUNNING,
            self::COMPLETED,
            self::ABORTED,
            self::FAILED,
        ]);
    }

    public function isPlanned(): bool
    {
        return $this === self::PLANNED;
    }

    public function isRunning(): bool
    {
        return $this === self::RUNNING;
    }

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    public function isAborted(): bool
    {
        return $this === self::ABORTED;
    }

    public function isFailed(): bool
    {
        return $this === self::FAILED;
    }
}
