<?php

namespace App\Livewire\CourseAssignments;

use App\Models\CourseAssignment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ListCourseAssignments extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(CourseAssignment::query())
            ->modifyQueryUsing(function (Builder $query) {
                $query->user(auth()->user())
                    ->untilNow();
            })
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('ordering')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_submissions'),
                Tables\Columns\IconColumn::make('published')
                    ->icon(function ($record) {
                        return $record->isActive() ? 'heroicon-o-pencil' : 'heroicon-o-clock';
                    }),
                Tables\Columns\TextColumn::make('published_up')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->datetime('Y-m-d H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_down')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->datetime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Submissions')
                    ->label(fn($record) => $record->isActive()?'Submissions':'Passed')
                    ->color(fn ($record) => $record->isActive()?'success':'danger')
                    ->icon(fn($record) => $record->isActive()?'heroicon-o-arrow-right-circle':'heroicon-o-clock')
                    ->disabled(fn ($record) => !$record->isActive())
                    ->url(fn ($record) => route('course-assignment.submissions', $record))
                    
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.course-assignments.list-course-assignments');
    }
}
