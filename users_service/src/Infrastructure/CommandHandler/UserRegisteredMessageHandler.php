<?php

declare(strict_types=1);

namespace App\Infrastructure\CommandHandler;

use App\Domain\Command\RegisterUserCommand;
use App\Domain\Event\UserRegisteredEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UserRegisteredMessageHandler
{
    private LoggerInterface $logger;
    private MessageBusInterface $messageBus;

    public function __construct(LoggerInterface $logger, MessageBusInterface $messageBus)
    {
        $this->logger = $logger;
        $this->messageBus = $messageBus;
    }

    public function __invoke(RegisterUserCommand $userCommand): void
    {
        $this->logger->info('User registered with Email ' . $userCommand->getEmail());

        $this->messageBus->dispatch(
            new UserRegisteredEvent($userCommand->getEmail(), $userCommand->getFirstName(), $userCommand->getLastName())
        );
    }
}