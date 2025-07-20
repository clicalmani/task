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
use Clicalmani\Task\Event\TaskExecutionEvent;
use Clicalmani\Task\Execution\TaskExecutionInterface;
use Clicalmani\Task\TaskInterface;

/**
 * Test for class TaskExecutionEvent.
 */
class TaskExecutionEventTest extends TestCase
{
    use ProphecyTrait;

    public function testGetTask()
    {
        $task = $this->prophesize(TaskInterface::class);
        $taskExecution = $this->prophesize(TaskExecutionInterface::class);

        $event = new TaskExecutionEvent($task->reveal(), $taskExecution->reveal());

        $this->assertEquals($task->reveal(), $event->getTask());
    }

    public function testGetTaskExecution()
    {
        $task = $this->prophesize(TaskInterface::class);
        $taskExecution = $this->prophesize(TaskExecutionInterface::class);

        $event = new TaskExecutionEvent($task->reveal(), $taskExecution->reveal());

        $this->assertEquals($taskExecution->reveal(), $event->getTaskExecution());
    }
}
