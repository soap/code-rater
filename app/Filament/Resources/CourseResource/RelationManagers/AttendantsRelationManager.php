<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendantsRelationManager extends RelationManager
{
    protected static string $relationship = 'attendants';

    protected static ?string $recordTitleAttribute = 'first_name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('is_active'),
                Forms\Components\DatePicker::make('started_at'),
                Forms\Components\DatePicker::make('enrolled_at'),
                Forms\Components\DatePicker::make('expired_at')->nullable(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')                
                    ->formatStateUsing(function ($record) {
                        return "{$record->first_name} {$record->last_name}";
                    })
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('enrolled_at')
                    ->date('d/m/Y'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_completed')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->recordSelect(fn (Select $select) => $select->placeholder('Select a user'))
                    ->recordTitle(fn ($record) => $record->name)
                    ->recordSelectSearchColumns(['first_name', 'last_name', 'email']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
