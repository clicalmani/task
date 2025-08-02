<?php

/**
 * Task runner for executing scheduled tasks.
 *
 * This class is responsible for running tasks based on their execution schedule.
 *
 * @package Clicalmani\Task\Runner
 * @since 1.0.0
 */
namespace Clicalmani\Task\Runner;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Clicalmani\Task\Event\Events;
use Clicalmani\Task\Event\TaskExecutionEvent;
use Clicalmani\Task\Execution\TaskExecutionInterface;
use Clicalmani\Task\Executor\ExecutorInterface;
use Clicalmani\Task\Executor\RetryException;
use Clicalmani\Task\Storage\TaskExecutionRepositoryInterface;
use Clicalmani\Task\TaskStatus;

class TaskRunner implements TaskRunnerInterface
{
    /**
     * @var TaskExecutionRepositoryInterface
     */
    private $taskExecutionRepository;

    /**
     * @var ExecutionFinderInterface
     */
    private $executionFinder;

    /**
     * @var ExecutorInterface
     */
    private $executor;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        TaskExecutionRepositoryInterface $taskExecutionRepository,
        ExecutionFinderInterface $executionFinder,
        ExecutorInterface $executor,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->taskExecutionRepository = $taskExecutionRepository;
        $this->executionFinder = $executionFinder;
        $this->executor = $executor;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function runTasks()
    {
        foreach ($this->executionFinder->find() as $execution) {
            try {
                $this->run($execution);
            } catch (ExitException $exception) {
                return;
            }
        }
    }

    /**
     * Run execution with given handler.
     *
     * @param TaskExecutionInterface $execution
     * @throws ExitException
     */
    private function run(TaskExecutionInterface $execution)
    {
        $start = microtime(true);
        $execution->setStartTime(new \DateTime());
        $execution->setStatus(TaskStatus::RUNNING);
        $this->taskExecutionRepository->save($execution);

        try {
            $execution = $this->hasPassed($execution, $this->handle($execution));
        } catch (ExitException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $execution = $this->hasFailed($execution, $exception);
        } finally {
            $this->finalize($execution, $start);
        }
    }

    /**
     * Handle given execution and fire before and after events.
     *
     * @param TaskExecutionInterface $execution
     * @return \Serializable|string
     * @throws ExitException
     */
    private function handle(TaskExecutionInterface $execution)
    {
        $this->dispatch(
            Events::TASK_BEFORE,
            new TaskExecutionEvent($execution->getTask(), $execution)
        );

        try {
            return $this->executor->execute($execution);
        } catch (RetryException $exception) {
            // this find is necessary because the storage could be
            // invalid (clear in doctrine) after handling an execution.
            $execution = $this->taskExecutionRepository->findByUuid($execution->getUuid());

            if ($execution->getAttempts() === $exception->getMaximumAttempts()) {
                throw $exception->getPrevious();
            }

            $execution->reset();
            $execution->incrementAttempts();

            $this->dispatch(
                Events::TASK_RETRIED,
                new TaskExecutionEvent($execution->getTask(), $execution)
            );

            $this->taskExecutionRepository->save($execution);

            throw new ExitException();
        } finally {
            $this->dispatch(
                Events::TASK_AFTER,
                new TaskExecutionEvent($execution->getTask(), $execution)
            );
        }
    }

    /**
     * The given task passed the run.
     *
     * @param TaskExecutionInterface $execution
     * @param mixed $result
     *
     * @return TaskExecutionInterface
     */
    private function hasPassed(TaskExecutionInterface $execution, $result)
    {
        // this find is necessary because the storage could be
        // invalid (clear in doctrine) after handling an execution.
        $execution = $this->taskExecutionRepository->findByUuid($execution->getUuid());
        $execution->setStatus(TaskStatus::COMPLETED);
        $execution->setResult($result);

        $this->dispatch(
            Events::TASK_PASSED,
            new TaskExecutionEvent($execution->getTask(), $execution)
        );

        $this->taskExecutionRepository->save($execution);

        return $execution;
    }

    /**
     * The given task failed the run.
     *
     * @param TaskExecutionInterface $execution
     * @param \Throwable $exception
     *
     * @return TaskExecutionInterface
     */
    private function hasFailed(TaskExecutionInterface $execution, \Exception $exception)
    {
        // this find is necessary because the storage could be
        // invalid (clear in doctrine) after handling an execution.
        $execution = $this->taskExecutionRepository->findByUuid($execution->getUuid());
        $execution->setException($exception->__toString());
        $execution->setStatus(TaskStatus::FAILED);

        $this->dispatch(
            Events::TASK_FAILED,
            new TaskExecutionEvent($execution->getTask(), $execution)
        );

        $this->taskExecutionRepository->save($execution);

        return $execution;
    }

    /**
     * Finalizes given execution.
     *
     * @param TaskExecutionInterface $execution
     * @param int $start
     */
    private function finalize(TaskExecutionInterface $execution, $start)
    {
        // this find is necessary because the storage could be
        // invalid (clear in doctrine) after handling an execution.
        $execution = $this->taskExecutionRepository->findByUuid($execution->getUuid());

        if (!$execution->getStatus()->isPlanned()) {
            $execution->setEndTime(new \DateTime());
            $execution->setDuration(microtime(true) - $start);
        }

        $this->dispatch(
            Events::TASK_FINISHED,
            new TaskExecutionEvent($execution->getTask(), $execution)
        );

        $this->taskExecutionRepository->save($execution);
    }

    private function dispatch($eventName, $event)
    {
        return $this->eventDispatcher->dispatch($event, $eventName);
    }
}
