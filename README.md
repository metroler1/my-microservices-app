# Microservices Application with Symfony

This repository contains a microservices application built using Symfony. The application consists of two microservices: "Users" and "Notifications," which communicate via a message bus. The "Users" microservice handles user registration and sends event notifications to the "Notifications" microservice.

## Prerequisites

- [Docker](https://www.docker.com/)
- [Symfony CLI](https://symfony.com/download)

## Getting Started

1. Clone this repository:
2. ```bash
   docker-compose up -d
   
   cd users_service
   symfony composer install
   cd ../notifications_service
   symfony composer install

## Testing
To run tests for each microservice:
1. ```bash
   cd users-service
   php bin/phpunit

## Architecture

The application is structured as follows:

- `users-service`: Contains the "Users" microservice.
- `notifications-service`: Contains the "Notifications" microservice.

Each microservice follows the Symfony application structure, including controllers, services, and tests.

