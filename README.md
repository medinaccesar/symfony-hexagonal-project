# Symfony Docker base 🐳

> Version:  **Symfony 6.3.5**

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


## 🤖 Database

- MySql (MariaDB)

```
- Database: symfony-database 
- user: root
- password: root
```

## 🎯 Hexagonal Architecture
This project uses a Hexagonal Architecture and is organized in modules.

```scala
└── User
    ├── Adapter
    │  ├── Framework
    │  │  └── HTTP
    │  │      └── Controller
    │  │          ├── CreateUserController.php
    │  │          ├── GetUserByIdController.php
    │  │          └── Security
    │  │              └── SecurityController.php
    │  └── Persistence
    │      └── ORM
    │          └── Doctrine
    │              ├── Mapping
    │              │  └── DoctrineUser.php
    │              └── Repository
    │                  └── DoctrineUserRepository.php
    ├── Application
    │  ├── Command
    │  │  └── CreateUser
    │  │      ├── CreateUser.php
    │  │      └── DTO
    │  │          └── CreateUserInputDTO.php
    │  └── Query
    │      └── GetUserByIdQuery.php
    └── Domain
        ├── Model
        │  └── User.php
        └── Repository
            └── UserRepositoryInterface.php

```
