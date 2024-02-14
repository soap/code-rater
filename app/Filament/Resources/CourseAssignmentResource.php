<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseAssignmentResource\Pages;
use App\Filament\Resources\CourseAssignmentResource\RelationManagers;
use App\Models\CourseAssignment;
use App\Filament\Traits\HasParentResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseAssignmentResource extends Resource
{    
    public static string $parentResource = CourseResource::class; 

    protected static ?string $model = CourseAssignment::class;
    
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->name;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('max_submissions')
                    ->required()
                    ->numeric()
                    ->default(3),
                Forms\Components\DateTimePicker::make('published_up')
                    ->required(),
                Forms\Components\DateTimePicker::make('published_down')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('max_submissions')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_up')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_down')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->url(
                        fn (Pages\ListCourseAssignments $livewire, Model $record): string => static::$parentResource::getUrl('course-assignments.edit', [
                            'record' => $record,
                            'parent' => $livewire->parent,
                        ])
                    ),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    
    public static function getPages(): array
    {
        return [];
    }
}
