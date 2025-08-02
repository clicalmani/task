<?php

/**
 * Recurring message interface.
 *
 * This interface defines the structure for recurring messages, including methods to retrieve
 * the cron expression, message object, and start date.
 *
 * @package Clicalmani\Task\Messenger
 * @since 1.0.0
 */
namespace Clicalmani\Task\Messenger;

interface RecurringMessageInterface
{
    /**
     * Creates a recurring message with the specified cron expression, message object, and start date.
     *
     * @param string $cronExpression
     * @param object $message
     * @param \DateTime $startDate
     * @return self
     */
    public static function cron(string $cronExpression, object $message, \DateTime $startDate) : self;
    
    /**
     * Creates an hourly recurring message.
     *
     * @param object $message
     * @param \DateTime $startDate
     * @return self
     */
    public function hourly(object $message, \DateTime $startDate) : self;

    /**
     * Creates a daily recurring message.
     *
     * @param object $message
     * @param \DateTime $startDate
     * @return self
     */
    public function daily(object $message, \DateTime $startDate) : self;

    /**
     * Creates a weekly recurring message.
     *
     * @param object $message
     * @param \DateTime $startDate
     * @return self
     */
    public function weekly(object $message, \DateTime $startDate) : self;

    /**
     * Creates a monthly recurring message.
     *
     * @param object $message
     * @param \DateTime $startDate
     * @return self
     */
    public function monthly(object $message, \DateTime $startDate) : self;

    /**
     * Creates a yearly recurring message.
     *
     * @param object $message
     * @param \DateTime $startDate
     * @return self
     */
    public function yearly(object $message, \DateTime $startDate) : self;

    /**
     * Returns the cron expression for the recurring message.
     *
     * @return string
     */
    public function getCronExpression() : string;

    /**
     * Returns the message object associated with the recurring message.
     *
     * @return object
     */
    public function getMessage() : object;

    /**
     * Returns the start date for the recurring message.
     *
     * @return \DateTime
     */
    public function getStartDate() : \DateTime;
}