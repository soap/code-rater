<?php

namespace App\Filament\Resources;

use App\Enums\SaleModeEnum;
use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\Filament\NestedResources\Resources\NestedResource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CourseResource extends NestedResource
{
    protected static ?string $model = Course::class;

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
                Forms\Components\Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General Information')
                            ->schema([
                                Forms\Components\Section::make('Course Information')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('description')
                                            ->maxLength(65535)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('max_participants')
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                    ]),
                                Forms\Components\Section::make('Publsihing Information')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\DatePicker::make('start_date')
                                            ->required(),
                                        Forms\Components\DatePicker::make('end_date'),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Sale Information')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('฿'),
                                Forms\Components\Select::make('sale_mode')
                                    ->required()
                                    ->options(SaleModeEnum::class),
                            ]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->description(fn (Course $record) => $record->slug)
                    ->searchable(),
                Tables\Columns\TextColumn::make('max_participants')
                    ->toggledHiddenByDefault()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('THB')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('sale_mode')
                    ->options(SaleModeEnum::class),
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
                Tables\Actions\Action::make('Assignments')
                    //->icon('heroicon-o-clipboard-list')
                    ->url(fn (Course $record) =>static::getUrl('assignments', [
                        'record' => $record->id
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
            RelationManagers\AssignmentsRelationManager::class,
            RelationManagers\AttendantsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'view' => Pages\ViewCourse::route('/{record}'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
            'assignments' => Pages\ManageAssignments::route('/{record}/assignments'),
        ];
    }
}
