<?php
/**
 * Este archivo define la interfaz UserRepositoryInterface,
 * que es un contrato para la persistencia de usuarios en el
 * dominio de administración de usuarios. Esta interfaz establece
 * los métodos que cualquier implementación de repositorio de
 * usuarios debe proporcionar, como guardar un usuario, encontrar
 * un usuario por su ID, obtener todos los usuarios y eliminar
 * un usuario por su ID. Las implementaciones concretas de esta
 * interfaz pueden utilizar diferentes tecnologías de
 * almacenamiento, como bases de datos relacionales, NoSQL,
 * o incluso almacenamiento en memoria, siempre y cuando cumplan
 *  con el contrato definido por esta interfaz.
 */
namespace Src\Admin\User\Domain\Contracts;

use Src\Admin\User\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;
    public function find(int $id): ?User;
    public function findAll(): array;
    public function delete(int $id): void;
}
