<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

     // Tambahan untuk ganti label
    protected static ?string $pluralLabel = 'Daftar siswa pkl';
    protected static ?string $label = 'Siswa';
    protected static ?string $navigationLabel = 'Siswa';

    protected static ?string $slug = 'siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),


                Forms\Components\TextInput::make('nis')
                    ->label('NIS')
                    ->required()
                    ->unique(Siswa::class, 'nis', ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'NIS ini sudah digunakan! Silakan masukkan NIS dengan benar.',
                    ])
                    ->maxLength(5),
                Forms\Components\Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki', 
                        'P' => 'Perempuan'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kontak')
                    ->required()
                    ->unique(Siswa::class,'kontak', ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Nomor ini sudah digunakan! Silakan masukkan nomor lain.',
                    ])
                    ->maxLength(15),
                Forms\Components\select::make('email')
                    //->email()
                    ->required()
                    ->searchable()
                    ->relationship('user', 'email')
                    ->unique(Siswa::class, 'email', ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Email ini sudah digunakan! Silakan masukkan Email dengan benar.',
                    ]),
                    //->maxLength(255),

                 Forms\Components\FileUpload::make('foto')
                    ->label('Foto siswa')
                    ->openable()
                    ->required()
                    ->previewable(),

                //menambah roles
                // Forms\Components\Select::make('roles')  
                //     ->relationship('roles', 'name')
                //     ->preload()
                //     ->searchable(),
                 
                // Forms\Components\Toggle::make('status_pkl')
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')  
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->formatStateUsing(fn ($state) => DB::select("SELECT getGenderCode(?) AS gender", [$state])[0]->gender),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                //image

                Tables\Columns\BadgeColumn::make('status_pkl')
                ->colors([
                    '0' => 'danger',  // Merah = Belum PKL
                    '1' => 'success', // Hijau = Sedang PKL
                ]),
                Tables\Columns\IconColumn::make('status_pkl')
                    ->boolean()
                    ,
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
                Tables\Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->action(function ($record) {
                    // Cek apakah siswa memiliki data PKL
                    $hasPkl = \App\Models\Pkl::where('siswa_id', $record->id)->exists();
                    
                    if ($hasPkl) {
                        \Filament\Notifications\Notification::make()
                            ->title('Tidak dapat menghapus data!')
                            ->body('Siswa ini memiliki data PKL yang terkait. Hapus data PKL terlebih dahulu.')
                            ->danger()
                            ->send();
                        
                        return; // Stop execution tanpa menghapus
                    }
                    
                    // Jika tidak ada PKL, hapus siswa
                    $record->delete();
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Data berhasil dihapus!')
                        ->success()
                        ->send();
                }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSiswas::route('/'),
        ];
    }
}