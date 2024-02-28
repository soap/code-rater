<?php

namespace App\Filament\Resources\CourseAssignmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\Filament\NestedResources\RelationManagers\NestedRelationManager;

class TestCasesRelationManager extends NestedRelationManager
{
    protected static string $relationship = 'testCases';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('ordering'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('command'),
            ])
            ->reorderable('ordering')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
