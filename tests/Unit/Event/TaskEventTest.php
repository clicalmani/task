<?php

/*
 * This file is part of php-task library.
 *
 * (c) php-task
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Clicalmani\Task\Tests\Unit\Event;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Clicalmani\Task\Event\TaskEvent;
use Clicalmani\Task\TaskInterface;

/**
 * Tests for class TaskEvent.
 */
class TaskEventTest extends TestCase
{
    use ProphecyTrait;

    public function testGetTask()
    {
        $task = $this->prophesize(TaskInterface::class);

        $event = new TaskEvent($task->reveal());

        $this->assertEquals($task->reveal(), $event->getTask());
    }
}
