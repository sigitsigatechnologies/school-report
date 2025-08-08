<?php

namespace App\Filament\Erapor\Resources\KategoriMateriResource\Pages;

use App\Filament\Erapor\Resources\KategoriMateriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriMateri extends EditRecord
{
    protected static string $resource = KategoriMateriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
