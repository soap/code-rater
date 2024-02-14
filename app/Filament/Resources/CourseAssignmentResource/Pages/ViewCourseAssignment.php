<?php

namespace App\Filament\Resources\CourseAssignmentResource\Pages;

use App\Filament\Resources\CourseAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCourseAssignment extends ViewRecord
{
    protected static string $resource = CourseAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
