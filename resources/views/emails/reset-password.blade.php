<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Akses Laboratorium - UAD Fisika</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f7f6; font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <div
        style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">

        <div style="background-color: #265166; padding: 25px; text-align: center; border-bottom: 4px solid #800000;">
            <h1 style="color: #ffffff; font-size: 22px; margin: 0; font-weight: 700;">
                LABORATORIUM FISIKA
            </h1>
            <p style="color: #ffffff; font-weight: 400; font-size: 14px; margin: 5px 0 0 0;">
                UNIVERSITAS AHMAD DAHLAN (UAD)
            </p>
        </div>

        <div style="padding: 30px;">

            <h2
                style="color: #265166; font-size: 18px; margin-top: 0; border-bottom: 1px dashed #ccc; padding-bottom: 10px; margin-bottom: 25px;">
                Inisialisasi Kata Sandi (Aksi Keamanan)
            </h2>

            <p style="margin-bottom: 20px;">Halo <strong style="color: #000;">{{ $user->name ?? 'Pengguna' }}</strong>,
            </p>

            <p style="margin-bottom: 25px; font-size: 15px;">Kami menerima permintaan otentikasi dari akun Anda. Untuk
                mengaktifkan kata sandi baru, mohon klik tombol **Verifikasi Data** di bawah ini:</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $url }}"
                    style="background-color: #4CAF50; color: #ffffff; padding: 12px 25px;
                        text-decoration: none;
                        border-radius: 8px;
                        font-weight: bold;
                        display: inline-block;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
                    Verifikasi Data & Reset Password
                </a>
            </div>

            <p
                style="border-left: 4px solid #ff9800; padding-left: 15px; margin-bottom: 20px; font-size: 14px; color: #555;">
                <strong style="color: #ff9800;">PERHATIAN:</strong> Tautan verifikasi ini hanya valid untuk **60
                menit**. Jangan bagikan email ini kepada siapapun.
            </p>

            <p style="font-size: 14px;">Jika Anda tidak pernah meminta prosedur ini, mohon abaikan email ini.</p>

        </div>

        <div
            style="background-color: #f0f0f0; padding: 20px; border-radius: 0 0 12px 12px; text-align: center; font-size: 12px; color: #777;">
            <p style="margin-top: 0; margin-bottom: 5px; color: #800000; font-weight: 600;">
                Program Studi Fisika, Fakultas Sains dan Teknologi Terapan
            </p>
            <p style="margin: 0; font-weight: 500;">
                <a href="{{ config('app.url') }}"
                    style="color: #4CAF50; text-decoration: none;">{{ config('app.url') }}</a>
            </p>
        </div>

    </div>

</body>

</html>
