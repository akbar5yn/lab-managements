<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Pemberitahuan Pembatalan Peminjaman</h2>
    
    <p>Yth. {{ $namaUser }},</p>
    
    <p>Kami mohon maaf, peminjaman Anda telah <strong>dibatalkan secara otomatis</strong> dengan detail berikut:</p>
    
    <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">No. Transaksi</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $noTransaksi }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">Nama Alat</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $namaAlat }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">Tanggal Pinjam</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $tanggalPinjam }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">Tanggal Kembali</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $tanggalKembali }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">Alasan</td>
            <td style="padding: 8px; border: 1px solid #ddd;">
                {{ $alasanPembatalan }} Seharusnya dikembalikan pada {{ $tanggalKembaliPeminjamLama }}.
            </td>
        </tr>
    </table>
    
    <p>Silakan lakukan peminjaman ulang pada tanggal lain atau hubungi pihak lab untuk informasi lebih lanjut.</p>
    
    <p>Terima kasih atas pengertian Anda.</p>
</body>
</html>