<?php

/**
 * Base event class for task events.
 *
 * This class serves as a base for all task-related events in the application.
 *
 * @package Clicalmani\Task\Event
 * @since 1.0.0
 */
namespace Clicalmani\Task\Event;

use Symfony\Contracts\EventDispatcher\Event as ContractsEvent;

/**
 * @internal
 */
abstract class BaseEvent extends ContractsEvent
{}
