<?php

namespace App\Filament\Resources\CourseAssignmentResource\Pages;

use App\Filament\Resources\CourseAssignmentResource;
use Filament\Actions;
use Guava\Filament\NestedResources\Pages\NestedViewRecord;

class ViewCourseAssignment extends NestedViewRecord
{
    protected static string $resource = CourseAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
