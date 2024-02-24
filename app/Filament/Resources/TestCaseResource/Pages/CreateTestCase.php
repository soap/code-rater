<?php

namespace App\Filament\Resources\TestCaseResource\Pages;

use App\Filament\Resources\TestCaseResource;
use Guava\Filament\NestedResources\Pages\NestedCreateRecord;

class CreateTestCase extends NestedCreateRecord
{
    protected static string $resource = TestCaseResource::class;
}
