<?php

namespace App\Filament\Clusters\Products\Resources;

use Illuminate\Support\Str;
use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Products;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Products\Resources\CategoryResource\Pages;
use App\Filament\Clusters\Products\Resources\CategoryResource\RelationManagers;
use App\Filament\Clusters\Products\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Clusters\Products\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Clusters\Products\Resources\CategoryResource\Pages\ListCategories;
use Filament\Forms\Components\Card;


class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = Products::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(50)
                            ->reactive() // Make the field reactive
                            ->afterStateUpdated(
                                fn(callable $set, $state) =>
                                $set('slug', Str::slug($state)) // Generate slug from name
                            ),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(50)
                            ->dehydrateStateUsing(fn($state) => Str::slug($state)), // Ensure slug format on save
                        Textarea::make('description')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
