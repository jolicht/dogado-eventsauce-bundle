<?php

declare(strict_types=1);

namespace Jolicht\DogadoEventsauceBundle;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher as MessageDispatcherInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessageDispatcher implements MessageDispatcherInterface
{
    public function __construct(
        private readonly MessageBusInterface $eventBus
    ) {
    }

    public function dispatch(Message ...$messages): void
    {
        foreach ($messages as $message) {
            $this->eventBus->dispatch($message->payload());
        }
    }
}
