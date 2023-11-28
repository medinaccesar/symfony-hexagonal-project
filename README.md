# Symfony hexagonal project
> - Version **Symfony 6.3.***

## Introduction 🌟
This project is a template for creating a Symfony application using the hexagonal architecture. It is based on the [php-ddd-example](https://github.com/CodelyTV/php-ddd-example) project, but with some changes and improvements.

## Table of contents 📖
- [Hexagonal Architecture](#hexagonal-architecture-overview-)
- [Prerequisites for manual installation](#prerequisites-for-manual-installation-)
- [Installation](#installation-)
  - [Docker](#docker-)
  - [Manual installation](#manual-installation-)
- [Bundles](#bundles-)

## Hexagonal architecture overview 🎯

 **Module example (Symfony)**:
```
└── Module
    ├── Application
    │   ├── Command
    │   │   └── CreateModule
    │   │       ├── CreateModuleCommand.php
    │   │       ├── CreateModuleCommandHandler.php
    │   │       ├── CreateModuleResponse.php
    │   │       └── ModuleCreator.php
    │   └── Query
    │       └── GetModuleById
    │           ├── GetModuleByIdFinder.php
    │           ├── GetModuleByIdQuery.php
    │           └── GetModuleByIdResponse.php
    ├── Domain
    │   ├── Event
    │   │   └── CreateModuleDomainEvent.php
    │   ├── Model
    │   │   └── Module.php
    │   ├── Repository
    │   │   └── ModuleRepositoryInterface.php
    │   ├── Security
    │   │   └── AllowedRoles.php
    │   └── Validation
    │       ├── CreateModuleValidator.php
    │       └── Trait
    │           └── RolesValidationTrait.php
    └── Infrastructure
        ├── Adapter
        │   ├── Persistence
        │   │   └── ORM
        │   │       └── Doctrine
        │   │           ├── Mapping
        │   │           │   └── Module.orm.xml
        │   │           └── Repository
        │   │               └── DoctrineModuleRepository.php
        │   ├── REST
        │   │   └── Symfony
        │   │       └── Controller
        │   │           ├── GetModuleByIdController
        │   │           │   └── GetModuleByIdController.php
        │   │           └── HealthCheckController
        │   │               └── HealthCheckController.php
        │   │           
        │   └── Security
        │       └── Symfony
        │           ├── ModuleAdapter.php
        │           └── ModuleProvider.php
        └── Config
            └── Symfony
                ├── Package
                │   └── module-doctrine.yaml
                └── Service
                    └── module.yaml

```
## Prerequisites for manual installation 🧾️
- PHP 8.3 or higher
- Composer
- MySQL or MariaDB
- RabbitMQ
- Redis
- Symfony CLI (optional)
- Grafana (optional)

#### Required PHP extensions
This project requires the following PHP extensions to be installed and enabled:

- **ext-amqp**: For working with RabbitMQ.
- **ext-ctype**: Used for character type checking.
- **ext-iconv**: For character encoding conversion.
- **ext-pdo**: Essential for PHP Data Object (PDO) database connections.
- **ext-redis**: Required for Redis integration.

## Installation 🚀

- **Clone the repository from GitHub.**

```shell
git clone https://github.com/tonicarreras/symfony-hexagonal-project.git
```

### Docker 🐳

- **Build and run the Docker containers (Makefile).**

```shell
# Build and run Docker containers
Make install
```

- **JWT PEM**

```shell
## Recommended: With passphrase
Make jwt-pp-config

# Without passphrase
Make jwt-config
```

- **Terminal**

```shell
# Enter the Docker container's terminal
Make sh
```

- **Database MySql (MariaDB)**

```
- Database: symfony-database 
- user: root
- password: root
```

- **Access the application**

You can access the application in your web browser at: 
- http://localhost:8000/ or http://localhost:8000/ui
- http://localhost:15672/ (RabbitMQ)
- http://localhost:9090/ (Prometheus)
- http://localhost:3000/ (Grafana)

### Manual installation 🖥

- Install dependencies:
```shell
composer install
```

- Database migrations:

You will need to configure the database connection by modifying the DATABASE_URL in the .env file to match your MySQL settings.
```shell
php bin/console doctrine:migrations:migrate
```

- JWT PEM
```shell
## Recommended: With passphrase
mkdir -p config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

# Without passphrase
mkdir -p config/jwt
openssl genrsa -out config/jwt/private.pem 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

- Start Symfony Server:
```shell
#Symfony CLI
symfony server:start
```
For more details on setting up Symfony, please refer to the [official Symfony documentation](https://symfony.com/doc/current/setup.html)

### JWT Configuration 🔑

After generating the keys with a passphrase, you need to update your environment configuration to include the passphrase. You can do this by modifying your `.env` file:
>JWT_PASSPHRASE=your_passphrase

However, for enhanced security, it is advisable to create a `.env.local` file in your project root if it does not already exist, and define the `JWT_PASSPHRASE` there. This ensures that your passphrase is not committed to your version control system:

## Bundles 🛠

[bundles.php](config/bundles.php)

## Acknowledgments

This project has benefited from ideas and code from the following projects and resources:
- [php-ddd-example](https://github.com/CodelyTV/php-ddd-example): Example of a PHP application using Domain-Driven Design (DDD) and Command Query Responsibility Segregation (CQRS) principles keeping the code as simple as possible (CodelyTV).
- [modular-monolith-example](https://github.com/codenip-tech/modular-monolith-example): Modular Monolith Example (Codenip).