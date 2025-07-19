<?php

namespace App\Filament\Erapor\Resources\PenilaianSumatifDetailResource\Pages;

use App\Filament\Erapor\Resources\PenilaianSumatifDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenilaianSumatifDetail extends EditRecord
{
    protected static string $resource = PenilaianSumatifDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
