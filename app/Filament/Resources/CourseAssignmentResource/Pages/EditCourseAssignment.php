<?php

namespace App\Filament\Resources\CourseAssignmentResource\Pages;

use App\Filament\Resources\CourseAssignmentResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseAssignment extends EditRecord
{
    use HasParentResource;

    protected static string $resource = CourseAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('course-assignments.index', [
            'parent' => $this->parent,
        ]);
    }
 
    protected function configureDeleteAction(Actions\DeleteAction $action): void
    {
        $resource = static::getResource();
 
        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(static::getParentResource()::getUrl('assignments.index', [
                'parent' => $this->parent,
            ]));
    }
}
