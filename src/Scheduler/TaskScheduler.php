<?php

/**
 * Task scheduler for managing and scheduling tasks.
 *
 * This class provides methods to create, add, and schedule tasks.
 *
 * @package Clicalmani\Task\Scheduler
 * @since 1.0.0
 */
namespace Clicalmani\Task\Scheduler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Clicalmani\Task\Builder\TaskBuilderFactoryInterface;
use Clicalmani\Task\Builder\TaskBuilderInterface;
use Clicalmani\Task\Event\Events;
use Clicalmani\Task\Event\TaskEvent;
use Clicalmani\Task\Event\TaskExecutionEvent;
use Clicalmani\Task\Storage\TaskExecutionRepositoryInterface;
use Clicalmani\Task\Storage\TaskRepositoryInterface;
use Clicalmani\Task\TaskInterface;
use Clicalmani\Task\TaskStatus;

class TaskScheduler implements TaskSchedulerInterface
{
    /**
     * @var TaskBuilderFactoryInterface
     */
    private $factory;

    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * @var TaskExecutionRepositoryInterface
     */
    private $taskExecutionRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        TaskBuilderFactoryInterface $factory,
        TaskRepositoryInterface $taskRepository,
        TaskExecutionRepositoryInterface $taskExecutionRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->factory = $factory;
        $this->taskRepository = $taskRepository;
        $this->taskExecutionRepository = $taskExecutionRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function createTask(string $handlerClass, ?object $workload = null) : TaskBuilderInterface
    {
        return $this->factory->createTaskBuilder($this->taskRepository->create($handlerClass, $workload), $this);
    }

    /**
     * {@inheritdoc}
     */
    public function addTask(TaskInterface $task) : TaskSchedulerInterface
    {
        $this->dispatch(Events::TASK_CREATE, new TaskEvent($task));

        $this->taskRepository->save($task);
        $this->scheduleTask($task);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function scheduleTasks() : void
    {
        $tasks = $this->taskRepository->findEndBeforeNow();
        foreach ($tasks as $task) {
            $this->scheduleTask($task);
        }
    }

    /**
     * Schedule execution for given task.
     *
     * @param TaskInterface $task
     */
    protected function scheduleTask(TaskInterface $task)
    {
        if (null !== ($execution = $this->taskExecutionRepository->findPending($task))) {
            return;
        }

        if (null === $task->getInterval() && 0 < count($this->taskExecutionRepository->findByTask($task))) {
            return;
        }

        $scheduleTime = $task->getInterval() ? $task->getInterval()->getNextRunDate() : $task->getFirstExecution();
        $execution = $this->taskExecutionRepository->create($task, $scheduleTime);
        $execution->setStatus(TaskStatus::PLANNED);

        $this->dispatch(
            Events::TASK_EXECUTION_CREATE,
            new TaskExecutionEvent($task, $execution)
        );

        $this->taskExecutionRepository->save($execution);
    }

    private function dispatch($eventName, $event)
    {
        return $this->eventDispatcher->dispatch($event, $eventName);
    }
}
