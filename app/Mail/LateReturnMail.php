<?php

namespace App\Mail;

use App\Models\TransaksiPeminjamanAlat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LateReturnMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi;

    public function __construct(TransaksiPeminjamanAlat $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Keterlambatan Pengembalian Alat',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.return-late',
            with: [
                'namaUser' => $this->transaksi->relasiUser->name,
                'namaAlat' => $this->transaksi->relasiUnit->unit->nama_alat,
                'noTransaksi' => $this->transaksi->no_transaksi,
                'tanggalPinjam' => $this->transaksi->tanggal_pinjam,
                'tanggalKembali' => $this->transaksi->tanggal_kembali,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
