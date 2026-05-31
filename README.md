# Estructura ddd
+-- src
|   +-- admin
|   |   +-- user
|   |   |   +-- application
|   |   |   |   +-- CreateUserUseCase.php
|   |   |   |   +-- GetUserByIdUseCase.php
|   |   |   +-- domain
|   |   |   |   +-- contracts
|   |   |   |   |   +-- UserRepositoryInterface.php
|   |   |   |   +-- entities
|   |   |   |   |   +-- User.php
|   |   |   |   +-- value_objects
|   |   |   |   |   +-- UserEmail.php
|   |   |   |   |   +-- UserName.php
|   |   |   +-- infrastructure
|   |   |   |   +-- controllers
|   |   |   |   |   +-- ExampleGetController.php
|   |   |   |   +-- events
|   |   |   |   +-- listeners
|   |   |   |   +-- repositories
|   |   |   |   |   +-- EloquentUserRepository.php
|   |   |   |   +-- routes
|   |   |   |   |   +-- api.php
|   |   |   |   +-- validators
|   |   |   |   |   +-- CreateUserRequest.php
|   +-- platform
|   |   +-- purchase
|   |   |   +-- application
|   |   |   +-- domain
|   |   |   +-- infrastructure