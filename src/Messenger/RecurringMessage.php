<?php
namespace Clicalmani\Task\Messenger;

class RecurringMessage
{
    public function __construct(
        private string $cronExpression = '',
        private ?object $message = null,
        private \DateTime|null $startDate = null
    )
    {}

    public static function cron(string $cronExpression, object $message, \DateTime $startDate)
    {
        return new self(
            $cronExpression,
            $message,
            $startDate
        );
    }

    public static function every(string $cronExpression, object $message, \DateTime $startDate)
    {
        return self::cron(
            $cronExpression,
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

    public function getStartDate() : \DateTime
    {
        return $this->startDate;
    }
}