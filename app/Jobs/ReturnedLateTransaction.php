<?php

namespace App\Jobs;

use App\Mail\LateReturnMail;
use App\Mail\BookingCancelledMail;
use App\Models\TransaksiPeminjamanAlat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReturnedLateTransaction implements ShouldQueue
{
    use Queueable;

    protected $noTransaksi;

    public function __construct(string $noTransaksi)
    {
        $this->noTransaksi = $noTransaksi;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Job ReturnedLateTransaction started', ['transaction_id' => $this->noTransaksi]);

        $transaksi = TransaksiPeminjamanAlat::find($this->noTransaksi);

        if (!$transaksi) {
            Log::warning('Transaksi tidak ditemukan', ['id' => $this->noTransaksi]);
            return;
        }

        if ($transaksi->status !== 'dipinjam') {
            Log::info('Job skip: status tidak memenuhi syarat', [
                'transaksi_id' => $this->noTransaksi,
                'status'       => $transaksi->status,
            ]);
            return;
        }

        $transaksi->update(['status' => 'terlambat_dikembalikan']);

        try {
            Mail::to($transaksi->relasiUser->email)->send(new LateReturnMail($transaksi));
            Log::info('Email keterlambatan berhasil dikirim', ['transaksi_id' => $this->noTransaksi]);
        } catch (\Exception $e) {
            Log::error('Gagal kirim email keterlambatan', ['error' => $e->getMessage()]);
        }

        $transaksiTerdampak = TransaksiPeminjamanAlat::where('id_unit', $transaksi->id_unit)
            ->where('id', '!=', $transaksi->id)
            ->whereIn('status', ['pending', 'dipinjam'])
            ->where('tanggal_pinjam', '<=', now()->toDateString()) 
            ->where('tanggal_pinjam', '>=', $transaksi->tanggal_kembali) 
            ->get();

        foreach ($transaksiTerdampak as $terdampak) {
            $terdampak->update(['status' => 'dibatalkan']);

            try {
                Mail::to($terdampak->relasiUser->email)
                    ->send(new BookingCancelledMail($terdampak, $transaksi));
                Log::info('Email pembatalan berhasil dikirim', ['transaksi_id' => $terdampak->id]);
            } catch (\Exception $e) {
                Log::error('Gagal kirim email pembatalan', ['error' => $e->getMessage()]);
            }
        }
    }
}
