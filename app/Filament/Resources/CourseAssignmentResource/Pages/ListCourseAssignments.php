<?php

namespace App\Filament\Resources\CourseAssignmentResource\Pages;

use App\Filament\Resources\CourseAssignmentResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseAssignments extends ListRecords
{
    use HasParentResource;

    protected static string $resource = CourseAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(
                fn (): string => static::getParentResource()::getUrl('course-assignments.create', [
                    'parent' => $this->parent,
                ])
            ),
        ];
    }
}
