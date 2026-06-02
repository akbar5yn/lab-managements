<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\TransaksiPeminjamanAlat; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;
use App\Mail\BookingCancelledMail;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    Log::info('Scheduler check-late-impact started', ['time' => now()->toDateTimeString()]);

    $transaksiTerlambat = TransaksiPeminjamanAlat::where('status', 'terlambat_dikembalikan')->get();

    if ($transaksiTerlambat->isEmpty()) {
        Log::info('Tidak ada transaksi terlambat.');
        return;
    }

    foreach ($transaksiTerlambat as $transaksi) {
        $terdampak = TransaksiPeminjamanAlat::where('id_unit', $transaksi->id_unit)
            ->where('id', '!=', $transaksi->id)
            ->whereIn('status', ['pending', 'dipinjam'])
            ->where('tanggal_pinjam', '<=', now()->toDateString())
            ->where('tanggal_pinjam', '>=', $transaksi->tanggal_kembali)
            ->get();

        if ($terdampak->isEmpty()) {
            Log::info('Tidak ada transaksi terdampak', ['transaksi_id' => $transaksi->id]);
            continue;
        }

        foreach ($terdampak as $item) {
            $item->update(['status' => 'dibatalkan']);
            Log::info('Transaksi terdampak dibatalkan', ['transaksi_id' => $item->id]);

            try {
                Mail::to($item->relasiUser->email)
                    ->send(new BookingCancelledMail($item, $transaksi));
                Log::info('Email pembatalan terdampak dikirim', ['transaksi_id' => $item->id]);
            } catch (\Exception $e) {
                Log::error('Gagal kirim email pembatalan', ['error' => $e->getMessage()]);
            }
        }
    }
})->dailyAt('08:00')->name('check-late-impact')->withoutOverlapping();