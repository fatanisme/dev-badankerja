<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use App\Models\JobList;
use App\Models\JobType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\JobCategory;
use App\Models\JobPosition;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use FilamentTiptapEditor\Enums\TiptapOutput;
use App\Filament\Resources\JobListResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JobListResource\RelationManagers;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class JobListResource extends Resource
{
    protected static ?string $model = JobList::class;
    protected static ?string $navigationLabel = 'Jobs';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Jobs';
    protected static ?int $navigationSort = -1;

    public static function getTableQuery(): Builder
    {
        return parent::getTableQuery()->with(['company', 'jobType', 'jobCategories']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->readonly()
                    ->columnSpanFull(), // Make slug readonly
                Forms\Components\Select::make('company_id')
                    ->options(Company::all()->pluck('name', 'id'))
                    ->label('Company')
                    ->required()
                    ->searchable()
                    ->reactive() // Enable reactivity
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('job_position_ids', null); // Clear positions when company changes
                        $set('slug', ''); // Clear slug when company changes
                    }),
                Forms\Components\Select::make('job_position_ids')
                    ->multiple()
                    ->options(JobPosition::all()->pluck('name', 'id'))
                    ->label('Job Position')
                    ->required()
                    ->searchable()
                    ->reactive() // Enable reactivity
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $companyId = $get('company_id');
                        $company = Company::find($companyId);
                        $positions = JobPosition::whereIn('id', $state)->pluck('name')->toArray(); // Convert to array

                        if ($company && !empty($positions)) {
                            // Create base slug
                            $baseSlug = 'lowongan-kerja-' . Str::slug($company->name) . '-' . Str::slug(implode('-', $positions));
                            $slug = $baseSlug;

                            // Check for existing slugs and increment if necessary
                            $count = 1;
                            while (JobList::where('slug', $slug)->exists()) {
                                $slug = $baseSlug . '-' . $count;
                                $count++;
                            }

                            // Set the generated slug
                            $set('slug', $slug);
                        } else {
                            // Clear slug if no company or positions are selected
                            $set('slug', '');
                        }
                    }),

                Forms\Components\Select::make('job_category_ids')
                    ->multiple()
                    ->options(JobCategory::all()->pluck('name', 'id'))
                    ->label('Job Category')
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('job_type_id')
                    ->options(JobType::all()->pluck('name', 'id'))
                    ->label('Job Type')
                    ->searchable(),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255),
                Forms\Components\TextInput::make('salary')
                    ->numeric(),

                TiptapEditor::make('description')
                    ->columnSpanFull()
                    ->maxContentWidth('full')
                    ->output(TiptapOutput::Html),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')->label('Company')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('job_category_ids')
                    ->label('Categories')
                    ->formatStateUsing(function ($state) {
                        // Menghapus spasi dan mengubah string menjadi array
                        if (is_string($state)) {
                            $state = array_map('trim', explode(',', $state));
                        }

                        if (is_array($state)) {
                            $categories = JobCategory::whereIn('id', $state)->pluck('name');
                            return $categories->isNotEmpty() ? $categories->implode(', ') : 'No Categories';
                        }

                        return 'Invalid Data';
                    }),
                Tables\Columns\TextColumn::make('job_position_ids')
                    ->label('Positions')
                    ->formatStateUsing(function ($state) {
                        // Menghapus spasi dan mengubah string menjadi array
                        if (is_string($state)) {
                            $state = array_map('trim', explode(',', $state));
                        }

                        if (is_array($state)) {
                            $positions = JobPosition::whereIn('id', $state)->pluck('name');
                            return $positions->isNotEmpty() ? $positions->implode(', ') : 'No Positions';
                        }

                        return 'Invalid Data';
                    }),
                Tables\Columns\TextColumn::make('jobType.name')->label('Job Type'),
                Tables\Columns\TextColumn::make('location')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('salary')->sortable(),
                Tables\Columns\TextColumn::make('slug'),
            ])
            ->filters([])
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobLists::route('/'),
            // 'create' => Pages\CreateJobList::route('/create'),
            // 'edit' => Pages\EditJobList::route('/{record}/edit'),
        ];
    }
}
