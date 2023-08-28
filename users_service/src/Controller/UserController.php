<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Command\RegisterUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    #[Route('/users', name: 'register_user', methods: ['POST'])]
    public function registerUser(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new RegisterUserCommand($data['email'], $data['firstName'], $data['lastName']);
        $this->commandBus->dispatch($command);

        return new Response('User creation initiated!', Response::HTTP_ACCEPTED);
    }
}
