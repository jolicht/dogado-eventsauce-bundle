<?php

declare(strict_types=1);

namespace Jolicht\DogadoEventsauceBundle\Tests;

use EventSauce\EventSourcing\Message;
use Jolicht\DogadoEventsauceBundle\MessageDispatcher;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @covers \Jolicht\DogadoEventsauceBundle\MessageDispatcher
 */
class MessageDispatcherTest extends TestCase
{
    private MessageBusInterface|MockObject $eventBus;
    private MessageDispatcher $messageDispatcher;

    protected function setUp(): void
    {
        $this->eventBus = $this->createMock(MessageBusInterface::class);
        $this->messageDispatcher = new MessageDispatcher($this->eventBus);
    }

    public function testDispatchDispatchesAllMessagesToEventBus(): void
    {
        $payload1 = new \stdClass();
        $message1 = new Message($payload1);

        $payload2 = new \stdClass();
        $message2 = new Message($payload2);

        $this->eventBus
            ->expects($this->exactly(2))
            ->method('dispatch')
            ->withConsecutive(
                [$payload1],
                [$payload2]
            )
            ->willReturnOnConsecutiveCalls(
                new Envelope(new \stdClass()),
                new Envelope(new \stdClass())
            );

        $this->messageDispatcher->dispatch($message1, $message2);
    }
}
