<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\TransaksiPeminjamanAlat;

class BookingCancelledMail extends Mailable
{
    use Queueable, SerializesModels;
    public $transaksiTerdampak; 
    public $transaksiTerlambat;

    /**
     * Create a new message instance.
     */
    public function __construct(
        TransaksiPeminjamanAlat $transaksiTerdampak,
        TransaksiPeminjamanAlat $transaksiTerlambat
    ){
        $this->transaksiTerdampak = $transaksiTerdampak;
        $this->transaksiTerlambat = $transaksiTerlambat;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Pembatalan Peminjaman Alat',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-cancelled',
            with: [
                'namaUser'          => $this->transaksiTerdampak->relasiUser->name,
                'namaAlat'          => $this->transaksiTerdampak->relasiUnit->unit->nama_alat,
                'noTransaksi'       => $this->transaksiTerdampak->no_transaksi,
                'tanggalPinjam'     => $this->transaksiTerdampak->tanggal_pinjam,
                'tanggalKembali'    => $this->transaksiTerdampak->tanggal_kembali,
                'tanggalKembaliPeminjamLama' => $this->transaksiTerlambat->tanggal_kembali,
                'alasanPembatalan'  => 'Peminjam sebelumnya belum mengembalikan alat hingga batas waktu yang ditentukan.',
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
