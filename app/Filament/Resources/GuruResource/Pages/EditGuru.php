<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuru extends EditRecord
{
    protected static string $resource = GuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    // app/Filament/Resources/GuruResource/Pages/EditGuru.php

    protected function afterSave(): void
    {
        if ($this->record->user && !$this->record->user->hasRole('guru')) {
            $this->record->user->assignRole('guru');
        }
    }

}
