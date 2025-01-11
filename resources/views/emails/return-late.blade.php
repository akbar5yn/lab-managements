<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pemberitahuan Keterlambatan Pengembalian Alat</title>

</head>

<body>
    <h1>Halo, {{ $namaUser }}</h1>
    <p>Transaksi Anda dengan ID: <strong>{{ $noTransaksi }}</strong> Sudah mencapai batas peminjaman.</p>
    <p>Berikut adalah detail transaksi anda:</p>

    <table>
        <tbody style="border-collapse: collapse; width: 100%; border: 1px solid #000;">
            <tr>
                <td
                    style="border: 1px solid #000; padding: 8px; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                    Nama Alat</td>
                <td
                    style="border: 1px solid #000; padding: 8px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                    {{ $namaAlat }}
                </td>
            </tr>
            <tr>
                <td
                    style="border: 1px solid #000; padding: 8px; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                    Tanggal Pinjam</td>
                <td
                    style="border: 1px solid #000; padding: 8px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                    {{ $tanggalPinjam }}</td>
            </tr>
            <tr>
                <td
                    style="border: 1px solid #000; padding: 8px; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                    Tanggal Kembali</td>
                <td
                    style="border: 1px solid #000; padding: 8px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                    {{ $tanggalKembali }}</td>
            </tr>
            <tr>
                <td
                    style="border: 1px solid #000; padding: 8px; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                    Status Peminjaman</td>
                <td
                    style="border: 1px solid #000; padding: 8px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                    Terlambat Dikembalikan</td>
            </tr>
        </tbody>
    </table>
    <p>Dari detail transaksi anda, bahwasannya anda terlambat untuk mengembalikan alat yang dipinjam, Harap segera
        melakukan pengembalian.</p>
    <strong>Mohon pengertiannya dan terimakasih.</strong>
</body>

</html>
