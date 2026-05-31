<?php
/**
 * Adaptador de repositorio para Eloquent ORM,
 * implementando la interfaz UserRepositoryInterface.
 *
 * Este adaptador se encarga de traducir las operaciones de la
 * aplicación a consultas de Eloquent ORM,
 * permitiendo así la persistencia de los datos en la base de datos.
 *
 * Este adaptador permite que la aplicación interactúe con la
 * base de datos utilizando Eloquent ORM, mientras mantiene la
 * separación de responsabilidades y la independencia de la
 * infraestructura.
 */
namespace Src\admin\user\infrastructure\repositories;

use Src\admin\user\domain\contracts\UserRepositoryInterface;
use Src\admin\user\domain\entities\User;
use Src\admin\user\domain\value_objects\UserName;
use Src\admin\user\domain\value_objects\UserEmail;
use App\Models\User as EloquentUser;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * Este adaptador debe implementar el contrato definido por UserRepositoryInterface,
     * utilizando Eloquent ORM para realizar las operaciones de persistencia.
     */
    public function find(int $id): ?User
    {
        $user = EloquentUser::find($id);
        if (!$user) {
            return null;
        }

        return new User(
            $user->id,
            new UserName($user->name),
            new UserEmail($user->email)
        );
    }

    public function save(User $user): void
    {
        EloquentUser::updateOrCreate(
            ['id' => $user->id()],
            [
                'name' => $user->name()->value(),
                'email' => $user->email()->value()
            ]
        );
    }

    public function findAll(): array
    {
        $users = EloquentUser::all();

        return $users->map(function (EloquentUser $model) {
            return new User(
                $model->id,
                new UserName($model->name),
                new UserEmail($model->email)
            );
        })->all();
    }

    public function delete(int $id): void
    {
        EloquentUser::destroy($id);
    }
}
