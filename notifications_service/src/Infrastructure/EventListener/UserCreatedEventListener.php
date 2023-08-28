<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Domain\Event\UserRegisteredEvent;
use Psr\Log\LoggerInterface;

final class UserCreatedEventListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onUserCreated(UserRegisteredEvent $event): void
    {
        // Log the user data
        $this->logger->info('User created: ' . json_encode([$event->getEmail(), $event->getLastName(), $event->getFirstName()], JSON_THROW_ON_ERROR));
    }
}