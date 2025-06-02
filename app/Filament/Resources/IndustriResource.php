<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndustriResource\Pages;
use App\Filament\Resources\IndustriResource\RelationManagers;
use App\Models\Industri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndustriResource extends Resource
{
    protected static ?string $model = Industri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Tambahan untuk ganti label
    protected static ?string $pluralLabel = 'Daftar industri';
    protected static ?string $label = 'Industri';
    protected static ?string $navigationLabel = 'Industri';

    protected static ?string $slug = 'industri';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bidang_usaha')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('website')
                    ->required()
                    ->prefix('https://')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kontak')
                    ->required()
                    ->unique(table: Industri::class, column: 'kontak')
                    ->validationMessages([
                        'unique' => 'Kontak ini sudah digunakan! Silakan masukkan Kontak dengan benar.',
                    ])
                    ->maxLength(15),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(table: Industri::class, column: 'email')
                    ->validationMessages([
                        'unique' => 'Email ini sudah digunakan! Silakan masukkan email dengan benar.',
                    ])
                    ->maxLength(255),
                // Forms\Components\Select::make('guru_pembimbing')
                //     ->label('Guru Pembimbing')
                //     ->relationship('guru', 'nama')//tampil nama guru
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bidang_usaha')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('guru.nama')
                //     ->searchable()
                //     ->label('Guru Pembimbing')
                //     ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageIndustris::route('/'),
        ];
    }
}