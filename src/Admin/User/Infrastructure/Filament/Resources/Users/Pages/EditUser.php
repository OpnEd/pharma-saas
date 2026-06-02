<?php

namespace Src\Admin\User\Infrastructure\Filament\Resources\Users\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Src\Admin\User\Infrastructure\Filament\Resources\Users\UserResource;
use Illuminate\Database\Eloquent\Model;
use Src\Admin\User\Application\UseCases\UpdateUserUseCase;
use Src\Admin\User\Application\Commands\UpdateUserCommand;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $command = new UpdateUserCommand(
            id: $record->id, // El ID viene del modelo Eloquent que Filament cargó
            name: $data['name'],
            email: $data['email']
        );

        $useCase = app(UpdateUserUseCase::class);
        $saved = $useCase->execute($command);

        // Update Eloquent fields from the returned domain user.
        // If the returned user contains all values Filament needs, we can
        // avoid the extra refresh query.
        $record->name = $saved->name()->value();
        $record->email = $saved->email()->value();

        if ($this->shouldRefreshRecord($saved)) {
            return $record->refresh();
        }

        return $record;
    }

    private function shouldRefreshRecord(\Src\Admin\User\Domain\Entities\User $saved): bool
    {
        // Keep refresh() if database-managed fields, casts, or derived values
        // may have changed and must be reloaded from the database.
        //
        // If your repository returns the full persisted state and you only
        // update simple fields, you can return false here to skip the query.
        return true;
    }
}
