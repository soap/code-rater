<?php

namespace App\Livewire;

use App\Models\CourseAssignment;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns;

class Assignments extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(auth()->user()->courseAssignments()->with('course')->query())
            ->columns([
                Columns\TextColumn::make('ordering')
                    ->sortable(),
                Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('course.name')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('max_submissions'),
                Columns\TextColumn::make('published_up')
                    ->datetime('Y-m-d H:i:s'),
                Columns\TextColumn::make('published_down')
                    ->datetime('Y-m-d H:i:s'),
            ])
            ->filters([

            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }

    public function render(): View
    {
        return view('livewire.assignments');
    }
}
