<?php

namespace App\Filament\Resources\TestCaseResource\Pages;

use App\Filament\Resources\TestCaseResource;
use Filament\Actions;
use Guava\Filament\NestedResources\Pages\NestedListRecords;

class ListTestCases extends NestedListRecords
{
    protected static string $resource = TestCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
