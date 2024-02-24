<?php

namespace App\Filament\Resources\TestCaseResource\Pages;

use App\Filament\Resources\TestCaseResource;
use Filament\Actions;
use Guava\Filament\NestedResources\Pages\NestedEditRecord;

class EditTestCase extends NestedEditRecord
{
    protected static string $resource = TestCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
