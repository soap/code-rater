<?php

namespace App\Filament\Resources\CourseAssignmentResource\Pages;

use App\Filament\Resources\CourseAssignmentResource;
use Guava\Filament\NestedResources\Pages\NestedListRecords;

class ListCourseAssignments extends NestedListRecords
{
    protected static string $resource = CourseAssignmentResource::class;
}
