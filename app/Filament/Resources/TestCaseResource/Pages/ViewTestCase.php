<?php

namespace App\Filament\Resources\TestCaseResource\Pages;

use App\Filament\Resources\TestCaseResource;
use Filament\Actions;
use Guava\Filament\NestedResources\Pages\NestedViewRecord;

class ViewTestCase extends NestedViewRecord
{
    protected static string $resource = TestCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
