<?php

namespace App\Filament\Admin\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'reference';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference')
                    ->columnSpan('full')
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->rules(['regex:/^\d+(\.\d{1,2})?$/'])
                    ->required(),

                Forms\Components\ToggleButtons::make('method')
                    ->inline()
                    ->options([
                        'dana' => 'Dana',
                        'gopay' => 'Gopay',
                        'linkaja' => 'LinkAja',
                        'ovo' => 'OVO',
                        'shopeepay' => 'ShopeePay',
                        'bank_transfer' => 'Bank Transfer',
                    ])
                    ->required(),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('payments')
                    ->visibility('public')
                    ->downloadable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColumnGroup::make('Details')
                    ->columns([
                        Tables\Columns\TextColumn::make('reference')
                            ->searchable(),

                        Tables\Columns\TextColumn::make('amount')
                            ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')) // Format as Rupiah
                            ->sortable(),

                        Tables\Columns\TextColumn::make('method')
                            ->formatStateUsing(fn($state) => Str::headline($state))
                            ->sortable(),
                    ])
            ])
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
