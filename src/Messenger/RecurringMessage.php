<?php
namespace Clicalmani\Task\Messenger;

class RecurringMessage
{
    public function __construct(
        private string $cronExpression = '',
        private string $handler = '',
        private mixed $workload = null,
        private \DateTime|null $from = null
    )
    {
        
    }

    public static function every(string $cronExpression, string $handler, mixed $workload, \DateTime $from)
    {
        return new self(
            $cronExpression,
            $handler,
            $workload,
            $from
        );
    }

    public static function getHandler() : string
    {
        return self::$handler;
    }

    public static function getWorkload() : string
    {
        return self::$workload;
    }
}