<?php

namespace spec\Akeneo\Tool\Bundle\BatchQueueBundle\Queue;

use Akeneo\Tool\Bundle\BatchQueueBundle\Queue\DatabaseJobExecutionQueue;
use Akeneo\Tool\Bundle\BatchQueueBundle\Queue\JobExecutionMessageRepository;
use Akeneo\Tool\Component\BatchQueue\Queue\JobExecutionMessage;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;

class DatabaseJobExecutionQueueSpec extends ObjectBehavior
{
    function let(
        EntityManagerInterface $entityManager,
        Connection $connection,
        JobExecutionMessageRepository $jobExecutionMessageRepository
    ) {
        $entityManager->getConnection()->willReturn($connection);
        $this->beConstructedWith($entityManager, $jobExecutionMessageRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DatabaseJobExecutionQueue::class);
    }

    function it_publishes_a_job_execution_message(
        $jobExecutionMessageRepository,
        JobExecutionMessage $jobExecutionMessage
    ) {
        $jobExecutionMessageRepository->createJobExecutionMessage($jobExecutionMessage)->shouldBeCalled();
        $this->publish($jobExecutionMessage);
    }

    function it_consumes_a_job_execution_message(
        $jobExecutionMessageRepository,
        JobExecutionMessage $jobExecutionMessage
    ) {
        $jobExecutionMessageRepository->getAvailableJobExecutionMessage()->willReturn($jobExecutionMessage);
        $jobExecutionMessageRepository->updateJobExecutionMessage($jobExecutionMessage)->willReturn(true);

        $jobExecutionMessage->consumedBy('consumer_name')->shouldBeCalled();

        $this->consume('consumer_name')->shouldReturn($jobExecutionMessage);
    }
}
