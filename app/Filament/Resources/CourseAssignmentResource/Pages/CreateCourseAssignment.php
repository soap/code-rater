<?php

namespace App\Filament\Resources\CourseAssignmentResource\Pages;

use App\Filament\Resources\CourseAssignmentResource;
use Filament\Actions;
use App\Filament\Traits\HasParentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseAssignment extends CreateRecord
{
    use HasParentResource;

    protected static string $resource = CourseAssignmentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('course-assignments.index', [
            'parent' => $this->parent,
        ]);
    }
 
    //   This can be moved to Trait, but we are keeping it here
    //   to avoid confusion in case you mutate the data yourself
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set the parent relationship key to the parent resource's ID.
        $data[$this->getParentRelationshipKey()] = $this->parent->id;
 
        return $data;
    }
}
