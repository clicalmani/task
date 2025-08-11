<?php

/**
 * Recurring message class.
 *
 * This class represents a recurring message with a cron expression, a message object, and a start date.
 *
 * @package Clicalmani\Task\Messenger
 * @since 1.0.0
 */
namespace Clicalmani\Task\Messenger;

class RecurringMessage implements RecurringMessageInterface
{
    public function __construct(
        private string $cronExpression = '',
        private ?object $message = null,
        private ?\DateTime $startDate = null
    )
    {}

    public static function cron(string $cronExpression, object $message, ?\DateTime $startDate = null) : self
    {
        return new self(
            $cronExpression,
            $message,
            $startDate
        );
    }

    public static function hourly(object $message, ?\DateTime $startDate = null) : self
    {
        return new self(
            '@hourly',
            $message,
            $startDate
        );
    }

    public static function daily(object $message, ?\DateTime $startDate = null) : self
    {
        return new self(
            '@daily',
            $message,
            $startDate
        );
    }

    public static function weekly(object $message, ?\DateTime $startDate = null) : self
    {
        return new self(
            '@weekly',
            $message,
            $startDate
        );
    }

    public static function monthly(object $message, ?\DateTime $startDate = null) : self
    {
        return new self(
            '@monthly',
            $message,
            $startDate
        );
    }

    public static function yearly(object $message, ?\DateTime $startDate = null) : self
    {
        return new self(
            '@yearly',
            $message,
            $startDate
        );
    }

    public function getMessage() : object
    {
        return $this->message;
    }

    public function getHandler() : string
    {
        return "\\App\Scheduler\Handler\\" . substr($this->message::class, strrpos($this->message::class, '\\') + 1) . 'Handler';
    }

    public function getCronExpression() : string
    {
        return $this->cronExpression;
    }

    public function getStartDate() : ?\DateTime
    {
        return $this->startDate;
    }
}