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
Module/
├── Application/
│   ├── Command/
│   │   ├── Handler/
│   │   │   └── CreateHandler.php       # Handles the logic for creating s
│   │   └── CreateCommand.php           # Defines the structure of the create command
│   ├── Query/
│   │   ├── Handler/
│   │   │   └── GetByIdHandler.php      # Handles the logic for querying s by ID
│   │   └── GetByIdQuery.php            # Defines the structure of the query by ID
│   └── Service/
│       └── Service.php                 # Application services that orchestrate the flow of use cases
├── Domain/
│   ├── Model/
│   │   └── .php                    # The domain entity and any related value objects
│   ├── Repository/
│   │   └── RepositoryInterface.php # Repository interface to abstract the persistence of 
│   ├── Service/
│   │   └── DomainService.php       # Domain-specific business logic for 
│   └── Event/
│       └── CreatedEvent.php        # Domain event that is triggered when a is created
├── Adapter/
│   ├── Persistence/
│   │   └── Repository.php          # Implementation of the repository (e.g., using Doctrine ORM)
│   ├── Messaging/
│   │   └── MessagePublisher.php    # Implementation for publishing events to a messaging system
│   ├── Web/
│   │   ├── Controller/
│   │   │   └── Controller.php      # RESTful controllers for operations
│   │   └── DTO/
│   │       ├── CreateRequest.php   # DTO for create request
│   │       └── Response.php        # DTO for response
│   └── CLI/
│       └── CreateCommand.php       # CLI command to create s
└── UI/
    ├── Web/
    │   └── Controller/
    │       └── Controller.php      # Web controller to interact with s through the web interface
    ├── CLI/
    │   └── CLIController.php       # CLI controller for operations through the command line
    └── API/
        └── Controller.php          # API controller for operations through the REST API

```
