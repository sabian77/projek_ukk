<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Filament\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

        // Tambahan untuk ganti label
    protected static ?string $pluralLabel = 'Daftar Guru pembimbing';
    protected static ?string $label = 'Guru';
    protected static ?string $navigationLabel = 'Guru';

    protected static ?string $slug = 'guru';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->required()
                    ->unique(Guru::class, 'nip', ignoreRecord: true) 
                    ->validationMessages([
                        'unique' => 'NIP ini sudah digunakan! Silakan masukkan NIP dengan benar.',
                    ])
                    ->maxLength(18),
                Forms\Components\Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kontak')
                    ->required()
                    ->unique(Guru::class, 'kontak', ignoreRecord: true) 
                    ->validationMessages([
                        'unique' => 'Kontak ini sudah digunakan! Silakan masukkan Kontak dengan benar.',
                    ])
                    ->maxLength(15),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(Guru::class,'email', ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Email ini sudah digunakan! Silakan masukkan email lain.',
                    ])
                    ->maxLength(255),

                

                // //menambah roles
                // Forms\Components\Select::make('roles')  
                //     ->relationship('roles', 'name')
                //     ->preload()
                //  ->searchable(),
                             
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->formatStateUsing(fn ($state) => DB::select("SELECT getGenderCode(?) AS gender", [$state])[0]->gender),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                // Tables\Columns\TextColumn::make('roles')
                //     ->label('Role')
                //     ->formatStateUsing(function ($state, $record) {
                //         return $record->getRoleNames()->join(', ');
                //     }),
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
            'index' => Pages\ManageGurus::route('/'),
        ];
    }
}