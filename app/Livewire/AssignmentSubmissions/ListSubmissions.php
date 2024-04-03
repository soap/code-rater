<?php

namespace App\Livewire\AssignmentSubmissions;

use App\Models\AssignmentSubmission;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ListSubmissions extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $courseAssignment;

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Components\FileUpload::make('file')
                    ->label('File')
                    ->required(),
                Components\Hidden::make('assignment_id')
                    ->default($this->courseAssignment->id),
                Components\Hidden::make('user_id')
                    ->default(auth()->user()->id),
            ]);
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(AssignmentSubmission::query())
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('course_assignment_id', $this->courseAssignment->id)
                    ->user(auth()->user());
            })
            ->columns([
                Tables\Columns\TextColumn::make('ordering')
                    ->label('Order')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file')
                    ->label('File')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->datetime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Submission')
                    ->slideOver()
                    ->form([
                        Components\FileUpload::make('file')
                            ->label('File')
                            ->required()
                            ->maxSize(2*1024) // 2MB
                            ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed', 'application/x-zip'])
                            ->disk('local')
                            ->directory('submissions')
                            ->visibility('private')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return str($file->getClientOriginalName())->prepend(auth()->id() . '-' 
                                    . $this->courseAssignment->id . '-' . now()->format('YmdHis') . '-');
                            }),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        $data['course_assignment_id'] = $this->courseAssignment->id;

                        return $data;
                    })->after(function () {
  
                    })->createAnother(false),
            ]);
    }

    public function render(): View
    {
        return view('livewire.assignment-submissions.list-submissions');
    }
}
