<?php

namespace App\Jobs;

use App\Models\TransaksiPeminjamanAlat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CancelExpiredTransaction implements ShouldQueue
{
    use Queueable;

    protected $noTransaksi;

    /**
     * Create a new job instance.
     */
    public function __construct(string $noTransaksi)
    {
        $this->noTransaksi = $noTransaksi;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transaksi = TransaksiPeminjamanAlat::find($this->noTransaksi);

        if ($transaksi && $transaksi->status === 'pending') {
            $transaksi->update(['status' => 'expire']);
        }
    }
}
