<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseAssignmentResource\Pages;
use App\Filament\Resources\CourseAssignmentResource\RelationManagers;
use App\Models\CourseAssignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\Filament\NestedResources\Ancestor;
use Guava\Filament\NestedResources\Resources\NestedResource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CourseAssignmentResource extends NestedResource
{
    protected static ?string $model = CourseAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $breadcrumbTitleAttribute = 'name';

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->name;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('course_id')
                    ->required()
                    ->numeric()->hidden(),
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
                Forms\Components\TextInput::make('points')
                    ->required()
                    ->numeric()
                    ->default(100),
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
                Tables\Columns\TextInput::make('points')
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
                Tables\Actions\EditAction::make(),
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
            RelationManagers\TestCasesRelationManager::class,
        ];
    }

    public static function getAncestor(): ?Ancestor
    {
        return Ancestor::make(CourseResource::class);
    }

    public static function getPages(): array
    {
        return [
            'create' => Pages\CreateCourseAssignment::route('/create'),
            'edit' => Pages\EditCourseAssignment::route('/{record}/edit'),
            'view' => Pages\ViewCourseAssignment::route('/{record}'),
        ];
    }
}
