<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Dikonfirmasi</title>
</head>
<body style="margin:0;padding:24px;background:#12060d;font-family:Arial,Helvetica,sans-serif;color:#ffffff;">
    <div style="max-width:520px;margin:0 auto;background:#1b0812;border:1px solid rgba(255,45,135,.35);border-radius:16px;padding:28px;">
        <p style="margin:0;font-size:19px;font-weight:bold;letter-spacing:.04em;color:#ff7ab3;">SAVE POINT PLAYSTATION</p>

        <h1 style="font-size:22px;margin:18px 0 8px;">Booking kamu sudah dikonfirmasi</h1>

        <p style="margin:0;color:rgba(255,255,255,.82);line-height:1.6;font-size:14px;">
            Halo, {{ $penyewa->name }}. Booking kamu sudah dikonfirmasi oleh pegawai kami.
            Berikut rinciannya:
        </p>

        <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;margin:18px 0;border-collapse:collapse;font-size:14px;">
            <tr>
                <td style="padding:8px 0;color:rgba(255,255,255,.55);width:42%;">Unit</td>
                <td style="padding:8px 0;font-weight:bold;">{{ $unit->name }}@if($unit->type) ({{ $unit->type }})@endif</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:rgba(255,255,255,.55);">Tanggal main</td>
                <td style="padding:8px 0;font-weight:bold;">{{ $booking->start_time->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:rgba(255,255,255,.55);">Jam</td>
                <td style="padding:8px 0;font-weight:bold;">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }} WIB</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:rgba(255,255,255,.55);">Total</td>
                <td style="padding:8px 0;font-weight:bold;">Rp {{ number_format((int) $booking->total_price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:rgba(255,255,255,.55);">Pembayaran</td>
                <td style="padding:8px 0;font-weight:bold;">
                    @if ($payment && $payment->status === 'paid')
                        Lunas
                    @elseif ($payment)
                        Menunggu pembayaran ({{ strtoupper($payment->method) }})
                    @else
                        Menunggu pembayaran
                    @endif
                </td>
            </tr>
        </table>

        <p style="margin:0;color:rgba(255,255,255,.82);line-height:1.6;font-size:14px;">
            Silakan datang sekitar 10 menit sebelum jam mulai dan tunjukkan email ini
            (atau nama akunmu) ke pegawai di tempat. Selamat bermain!
        </p>

        <p style="margin:22px 0 0;color:rgba(255,255,255,.4);font-size:12px;line-height:1.6;">
            Email ini dikirim otomatis oleh sistem booking Save Point PlayStation.
            Kalau kamu merasa tidak membuat booking ini, abaikan saja email ini.
        </p>
    </div>
</body>
</html>
