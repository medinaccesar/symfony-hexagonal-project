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

> **Module example**:
```
$ tree ./src/

./src/
└── User
    ├── Adapter
    │   ├── Framework
    │   │   ├── Config
    │   │   │   └── Service
    │   │   │       └── user.yaml
    │   │   └── HTTP
    │   │       ├── Controller
    │   │       │   ├── CreateUserController.php
    │   │       │   └── GetUserByIdController.php
    │   │       └── DTO
    │   │           └── GetUserByIdRequestDTO.php
    │   └── Persistence
    │       └── ORM
    │           └── Doctrine
    │               ├── Mapping
    │               │   └── User.orm.xml
    │               └── Repository
    │                   └── DoctrineUserRepository.php
    ├── Application
    │   ├── Command
    │   │   └── CreateUser
    │   │       ├── CreateUserCommand.php
    │   │       └── DTO
    │   │           └── CreateUserInputDTO.php
    │   └── Query
    │       └── GetUserById
    │           ├── DTO
    │           │   ├── GetUserByIdInputDTO.php
    │           │   └── GetUserByIdOutputDTO.php
    │           └── GetUserByIdQuery.php
    └── Domain
        ├── Model
        │   └── User.php
        └── Repository
            └── UserRepositoryInterface.php

```
