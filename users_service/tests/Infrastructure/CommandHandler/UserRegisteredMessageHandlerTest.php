<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\CommandHandler;

use App\Domain\Command\RegisterUserCommand;
use App\Domain\Event\UserRegisteredEvent;
use App\Infrastructure\CommandHandler\UserRegisteredMessageHandler;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class UserRegisteredMessageHandlerTest extends TestCase
{
    public function testUserRegistration(): void
    {
        $email = 'test@example.com';
        $firstName = 'John';
        $lastName = 'Doe';

        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock->expects($this->once())
            ->method('info')
            ->with($this->equalTo('User registered with Email ' . $email));

        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $messageBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($subject) use ($email, $firstName, $lastName) {
                return $subject instanceof UserRegisteredEvent &&
                    $subject->getEmail() === $email &&
                    $subject->getFirstName() === $firstName &&
                    $subject->getLastName() === $lastName;
            }))
            ->willReturn(new Envelope(new \stdClass())); // Return a real instance of Envelope wrapping a dummy object

        $handler = new UserRegisteredMessageHandler($loggerMock, $messageBusMock);

        $handler(new RegisterUserCommand($email, $firstName, $lastName));
    }
}