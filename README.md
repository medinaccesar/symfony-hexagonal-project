# Symfony Docker base 🐳

> Version: **Symfony 6.3.5**

Clone the repository from GitHub.

```shell
git clone https://github.com/tonicarreras/symfony-docker-base.git
```

## 🚀 Installation with Docker

### Build and run the Docker containers (Makefile).

```shell
# Build and run Docker containers
Make install
```

```shell
# Enter the Docker container's terminal
Make sh
```
### Access the application

You can access the application at http://localhost:8080/ in your web browser.

## 🖥️ Installation without Docker

```shell
composer install
```
```shell
php bin/console doctrine:migrations:migrate
```

```shell
#Symfony CLI
symfony server:start
```

For more details on setting up Symfony, please refer to the [official Symfony documentation](https://symfony.com/doc/current/setup.html)

## 🛠️ Bundles

- ORM
- MakerBundle
- SecurityBundle
- MonologBundle
- DebugBundle
- LexikJWTAuthenticationBundle (JWT)


## 🤖 Database

- MySql (MariaDB)

```
- Database: symfony-database 
- user: root
- password: root
```

## 🎯 Hexagonal Architecture
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
