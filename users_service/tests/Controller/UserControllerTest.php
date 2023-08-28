<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\UserController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Envelope;

class UserControllerTest extends WebTestCase
{
    public function testRegisterUser(): void
    {
        $sampleData = [
            'email' => 'sample@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe'
        ];

        $commandBusMock = $this->createMock(MessageBusInterface::class);
        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($subject) use ($sampleData) {
                return $subject->getEmail() === $sampleData['email']
                    && $subject->getFirstName() === $sampleData['firstName']
                    && $subject->getLastName() === $sampleData['lastName'];
            }))
            ->willReturn(new Envelope(new \stdClass()));

        $controller = new UserController($commandBusMock);

        $request = new Request([], [], [], [], [], [], json_encode($sampleData, JSON_THROW_ON_ERROR));

        $response = $controller->registerUser($request);

        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
        $this->assertEquals('User creation initiated!', $response->getContent());
    }
}