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
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\Select::make('company_id')
                    ->options(Company::all()->pluck('name', 'id'))
                    ->label('Company')
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('job_category_id')
                    ->options(JobCategory::all()->pluck('name', 'id'))
                    ->label('Job Category')
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('job_type_id')
                    ->options(JobType::all()->pluck('name', 'id'))
                    ->label('Job Type')
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('salary')
                    ->numeric(),
                Forms\Components\TextInput::make('slug')
                    ->required(),
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
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('company_id')->label('Company'),
                Tables\Columns\TextColumn::make('job_category_id')->label('Job Category'),
                Tables\Columns\TextColumn::make('job_type_id')->label('Job Type'),
                Tables\Columns\TextColumn::make('location')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('salary')->sortable(),
                Tables\Columns\TextColumn::make('slug'),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
