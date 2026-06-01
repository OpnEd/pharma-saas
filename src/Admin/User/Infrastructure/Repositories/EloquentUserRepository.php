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
namespace Src\Admin\User\Infrastructure\Repositories;

use Src\Admin\User\Domain\Contracts\UserRepositoryInterface;
use Src\Admin\User\Domain\Entities\User;
use Src\Admin\User\Domain\ValueObjects\UserName;
use Src\Admin\User\Domain\ValueObjects\UserEmail;
use Src\Admin\User\Domain\ValueObjects\UserPassword;
use Src\Admin\User\Domain\ValueObjects\UserEmailVerifiedAt;
use Src\Admin\User\Domain\ValueObjects\UserRememberToken;
use Src\Admin\User\Domain\ValueObjects\UserCreatedAt;
use Src\Admin\User\Domain\ValueObjects\UserUpdatedAt;
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
            new UserEmail($user->email),
            $user->password ? new UserPassword($user->password) : null,
            $user->email_verified_at ? new UserEmailVerifiedAt($user->email_verified_at) : null,
            $user->remember_token ? new UserRememberToken($user->remember_token) : null,
            $user->created_at ? new UserCreatedAt($user->created_at) : null,
            $user->updated_at ? new UserUpdatedAt($user->updated_at) : null
        );
    }

    public function save(User $user): void
    {
        $attributes = [
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
        ];

        if ($user->password() !== null) {
            $attributes['password'] = $user->password()->value();
        }

        if ($user->emailVerifiedAt() !== null) {
            $attributes['email_verified_at'] = $user->emailVerifiedAt()->value()->format('Y-m-d H:i:s');
        }

        if ($user->rememberToken() !== null) {
            $attributes['remember_token'] = $user->rememberToken()->value();
        }

        EloquentUser::updateOrCreate(
            ['id' => $user->id()],
            $attributes
        );
    }

    public function findAll(): array
    {
        $users = EloquentUser::all();

        return $users->map(function (EloquentUser $model) {
            return new User(
                $model->id,
                new UserName($model->name),
                new UserEmail($model->email),
                $model->password ? new UserPassword($model->password) : null,
                $model->email_verified_at ? new UserEmailVerifiedAt($model->email_verified_at) : null,
                $model->remember_token ? new UserRememberToken($model->remember_token) : null,
                $model->created_at ? new UserCreatedAt($model->created_at) : null,
                $model->updated_at ? new UserUpdatedAt($model->updated_at) : null
            );
        })->all();
    }

    public function delete(int $id): void
    {
        EloquentUser::destroy($id);
    }
}
