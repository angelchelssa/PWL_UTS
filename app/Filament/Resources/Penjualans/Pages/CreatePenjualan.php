<?php

namespace App\Filament\Resources\Penjualans\Pages;

use App\Filament\Resources\Penjualans\PenjualanResource;
use App\Models\Stok;
use Filament\Resources\Pages\CreateRecord;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function afterCreate(): void
    {
        // Kurangi stok setiap barang yang dijual
        foreach ($this->record->details as $detail) {
            $stokTersedia = Stok::where('barang_id', $detail->barang_id)
                ->orderBy('stok_tanggal', 'asc')
                ->get();

            $jumlahDikurangi = $detail->jumlah;

            foreach ($stokTersedia as $stok) {
                if ($jumlahDikurangi <= 0) break;

                if ($stok->stok_jumlah <= $jumlahDikurangi) {
                    $jumlahDikurangi -= $stok->stok_jumlah;
                    $stok->stok_jumlah = 0;
                } else {
                    $stok->stok_jumlah -= $jumlahDikurangi;
                    $jumlahDikurangi = 0;
                }

                $stok->save();
            }
        }
    }
}