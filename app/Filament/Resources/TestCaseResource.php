<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestCaseResource\Pages;
use App\Models\TestCase;
use App\Enums\TestTypeEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\Filament\NestedResources\Ancestor;
use Guava\Filament\NestedResources\Resources\NestedResource;

class TestCaseResource extends NestedResource
{
    protected static ?string $model = TestCase::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $breadcrumbTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('course_assignment_id')
                    ->required()
                    ->numeric()->hidden(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('passed_score')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('failed_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('test_type_id')
                    ->required()
                    ->options(TestTypeEnum::class),

                Forms\Components\TextInput::make('command')
                    ->maxLength(255),
                Forms\Components\Textarea::make('input')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('output')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('match_type')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('test_type_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('passed_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('failed_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('command')
                    ->searchable(),
                Tables\Columns\IconColumn::make('match_type')
                    ->boolean(),
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
            //
        ];
    }

    public static function getAncestor(): ?Ancestor
    {
        return Ancestor::make(CourseAssignmentResource::class, 'courseAssignment');
    }

    public static function getPages(): array
    {
        return [
            'create' => Pages\CreateTestCase::route('/create'),
            'view' => Pages\ViewTestCase::route('/{record}'),
            'edit' => Pages\EditTestCase::route('/{record}/edit'),
        ];
    }
}
