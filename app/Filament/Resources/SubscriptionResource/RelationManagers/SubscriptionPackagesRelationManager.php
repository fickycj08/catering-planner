<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionPackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptionPackages';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('package_id')
                    ->label('Paket')
                    ->options(Package::all()->pluck('name', 'id'))
                    ->required(),
                    
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('package.name')
                    ->label('Nama Paket'),
                    
                Tables\Columns\TextColumn::make('quantity'),
                    
                Tables\Columns\TextColumn::make('subtotal')
                    ->money('IDR'),
            ]);
    }
}