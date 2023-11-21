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

## Software Architecture Best Practices

### Domain Layer
- **Framework Agnostic**: Ensure the domain layer is free from external frameworks or libraries.
- **Business Focus**: Include only business-related logic and rules. Avoid technical details.

### Application Layer
- **Thin Layer**: Focus on orchestrating the data flow between the domain and infrastructure.
- **Framework Independence**: Interact with frameworks without embedding framework-specific logic.

### Infrastructure Layer
- **Environment-Specific**: Handles database access, file systems, external services.
- **Framework Dependencies**: This is where framework-specific code belongs.

### General Guidelines
- **Avoid Leaky Abstractions**: No layer should leak into another.
- **Dependency Direction**: Dependencies should point inwards, from outer layers to the Domain.
- **Testing**: Independence of the domain layer eases unit testing for business logic.

These principles guide towards a maintainable, scalable architecture adaptable to changes.


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

You can access the application at http://localhost:8080/ or http://localhost:8080/ui in your web browser

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