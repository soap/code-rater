<?php

namespace App\Filament\Resources\CourseAssignmentResource\Pages;

use App\Filament\Resources\CourseAssignmentResource;
use Guava\Filament\NestedResources\Pages\NestedCreateRecord;

class CreateCourseAssignment extends NestedCreateRecord
{
    protected static string $resource = CourseAssignmentResource::class;
}
