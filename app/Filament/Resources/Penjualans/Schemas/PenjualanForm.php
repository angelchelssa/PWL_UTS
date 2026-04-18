<?php

namespace App\Filament\Resources\Penjualans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;

class PenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('penjualan_kode')
                    ->label('Kode Penjualan')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),

                Select::make('user_id')
                    ->label('Kasir')
                    ->relationship('user', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('pembeli')
                    ->label('Nama Pembeli')
                    ->required()
                    ->maxLength(50),

                DateTimePicker::make('penjualan_tanggal')
                    ->label('Tanggal Penjualan')
                    ->default(now())
                    ->required(),

                Repeater::make('detail')
                    ->label('Detail Barang')
                    ->relationship('detail')
                    ->schema([
                        Select::make('barang_id')
                            ->label('Barang')
                            ->relationship('barang', 'barang_nama')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive(),

                        TextInput::make('harga')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->required(),
                    ])
                    ->columns(3)
                    ->required()
                    ->addActionLabel('Tambah Barang'),
            ]);
    }
}