<?php

namespace App\Jobs;

use App\Mail\LateReturnMail;
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

        if ($transaksi && $transaksi->status === 'dipinjam') {
            $transaksi->update(['status' => 'terlambat_dikembalikan']);
            try {
                Mail::to($transaksi->relasiUser->email)->send(new LateReturnMail($transaksi));
                Log::info('Email berhasil dikirim.');
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email:', ['error' => $e->getMessage()]);
            }
        }
    }
}
