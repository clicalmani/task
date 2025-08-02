<?php

/**
 * Executes handler inside current process.
 * 
 * This executor is used to run tasks synchronously within the same process.
 * It is suitable for tasks that do not require asynchronous processing or when immediate execution is needed.
 * 
 * @package Clicalmani\Task\Executor
 * @since 1.0.0
 */
namespace Clicalmani\Task\Executor;

use Clicalmani\Task\Execution\TaskExecutionInterface;
use Clicalmani\Task\Handler\TaskHandlerFactoryInterface;

class InsideProcessExecutor implements ExecutorInterface
{
    /**
     * @var TaskHandlerFactoryInterface
     */
    private $handlerFactory;

    /**
     * @param TaskHandlerFactoryInterface $handlerFactory
     */
    public function __construct(TaskHandlerFactoryInterface $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(TaskExecutionInterface $execution)
    {
        $handler = $this->handlerFactory->create($execution->getHandlerClass());

        try {
            return $handler($execution->getWorkload());
        } catch (FailedException $exception) {
            throw $exception->getPrevious();
        } catch (\Exception $exception) {
            if (!$handler instanceof RetryTaskHandlerInterface) {
                throw $exception;
            }

            throw new RetryException($handler->getMaximumAttempts(), $exception);
        }
    }
}
