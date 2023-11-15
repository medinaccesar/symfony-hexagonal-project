# Symfony hexagonal project
> - Version **Symfony 6.3.***

## Índice
- [Hexagonal Architecture](#hexagonal-architecture-)
- [Prerequisites for manual installation](#prerequisites-for-manual-installation-)
- [Installation](#installation-)
  - [Docker](#docker-)
  - [Manual installation](#manual-installation-)
- [Bundles](#bundles-)

## Hexagonal Architecture 🎯
This API is structured on the tenets of Domain-Driven Design (DDD), embracing a model-centric strategy that
securely encapsulates business logic. It employs the Command Query Responsibility Segregation (CQRS) pattern to
distinctively separate read and write operations, thus enhancing clarity and scalability. Additionally, it is
organized as a modular monolith, which arranges the codebase into well-defined modules. This modularization
facilitates maintainability and allows for independent evolution of each module, laying a solid foundation for a
potential shift to a microservices architecture if needed.

> **Module example (Symfony)**:
```
├── Application
│   ├── Command
│   │   └── CreateModule
│   └── Query
│       └── GetModuleById
│           ├── GetModuleByIdHandler.php
│           ├── GetModuleByIdQuery.php
│           └── GetModuleByIdResponse.php
├── Domain
│   ├── Model
│   │   └── Module.php
│   └── Repository
│       └── ModuleRepositoryInterface.php
└── Infrastructure
    ├── Adapter
    │   ├── Persistence
    │   │   └── ORM
    │   │       └── Doctrine
    │   │           ├── Mapping
    │   │           │   └── Module.orm.xml
    │   │           └── Repository
    │   │               └── DoctrineModuleRepository.php
    │   └── REST
    │       └── Symfony
    │           └── Controller
    │               ├── CreateModuleController
    │               │   ├── CreateModuleController.php
    │               │   └── DTO
    │               │       └── CreateModuleRequestDTO.php
    │               └── GetModuleByIdController
    │                   ├── DTO
    │                   │   └── GetModuleByIdRequestDTO.php
    │                   └── GetModuleByIdController.php
    └── Config
        └── (Framework config)

```
## Prerequisites for manual installation 🧾️
- PHP 8.2 or higher
- Composer
- Symfony CLI
- MySQL or MariaDB

## Installation 🚀

Clone the repository from GitHub.

```shell
git clone https://github.com/tonicarreras/symfony-hexagonal-project.git
```

### Docker 🐳

- **Build and run the Docker containers (Makefile).**

```shell
# Build and run Docker containers
Make install
```

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

You can access the application at http://localhost:8080/ in your web browser.

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

#### JWT Configuration
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

#### Start Symfony Server:
```shell
#Symfony CLI
symfony server:start
```

For more details on setting up Symfony, please refer to the [official Symfony documentation](https://symfony.com/doc/current/setup.html)

## Bundles 🛠

- ORM
- MakerBundle
- SecurityBundle
- MonologBundle
- DebugBundle
- LexikJWTAuthenticationBundle (JWT)

## Acknowledgments

This project has benefited from ideas and code from the following projects and resources:
- [php-ddd-example](https://github.com/CodelyTV/php-ddd-example): Example of a PHP application using Domain-Driven Design (DDD) and Command Query Responsibility Segregation (CQRS) principles keeping the code as simple as possible (CodelyTV).
- [modular-monolith-example](https://github.com/codenip-tech/modular-monolith-example): Modular Monolith Example (Codenip).