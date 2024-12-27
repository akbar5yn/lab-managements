<?php

namespace App\Jobs;

use App\Models\TransaksiPeminjamanAlat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

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
        }
    }
}
