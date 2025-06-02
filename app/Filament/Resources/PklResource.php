<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PklResource\Pages;
use App\Filament\Resources\PklResource\RelationManagers;
use App\Models\Pkl;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Carbon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PklResource extends Resource
{
    protected static ?string $model = Pkl::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Tambahan untuk ganti label
    protected static ?string $pluralLabel = 'Daftar Tempat PKL';
    protected static ?string $label = 'PKL';
    protected static ?string $navigationLabel = 'PKL';

    protected static ?string $slug = 'pkl';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('siswa_id')
                ->label('Nama Siswa')
                ->relationship('siswa', 'nama')
                ->required()
                ->unique(ignoreRecord: true)
                ->searchable() // Memungkinkan pencarian dalam dropdown
                //->allowCustomValues() // Memungkinkan input manual selain data relasi
                ->validationMessages([
                    'unique' => 'Siswa ini sudah terdaftar input data PKL!',
                ]),            
                Forms\Components\Select::make('industri_id')
                    ->label('Industri')
                    ->relationship('industri', 'nama')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('guru_id')
                    ->label('Guru Pembimbing')
                    ->relationship('guru', 'nama')
                    ->required(),
                Forms\Components\DatePicker::make('mulai')
                    ->required(),
                Forms\Components\DatePicker::make('selesai')
                    ->after('mulai')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.nama')
                    ->searchable()
                    ->label('Nama Siswa'),
                Tables\Columns\TextColumn::make('industri.nama')
                    ->searchable()
                    ->label('Industri'),
                Tables\Columns\TextColumn::make('guru.nama')
                    ->searchable()
                    ->label('Guru Pembimbing'),
                Tables\Columns\TextColumn::make('mulai')
                    ->date(),
                Tables\Columns\TextColumn::make('selesai')
                    ->date(),
                Tables\Columns\TextColumn::make('selisih_hari')
                ->label('Durasi (Hari)')
                ->getStateUsing(fn (Pkl $record) => Carbon::parse($record->mulai)->diffInDays(Carbon::parse($record->selesai))),
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

    public static function beforeDelete(Siswa $record): void
    {
    $isSiswaInPkl = DB::table('pkls')->where('siswa_id', $record->id)->exists();

    if ($isSiswaInPkl) {
        abort(403, 'Siswa ini sedang use Illuminate\Support\Facades\DB;PKL dan tidak bisa dihapus.');
    }
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePkls::route('/'),
        ];
    }
}