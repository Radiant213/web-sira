<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi OTP</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #0ea5e9;
            padding: 32px 24px;
            text-align: center;
        }
        .header img {
            height: 48px;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.025em;
        }
        .content {
            padding: 40px 24px;
            text-align: center;
        }
        .content h2 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 16px;
        }
        .content p {
            margin: 0 0 24px 0;
            font-size: 16px;
        }
        .otp-box {
            display: inline-block;
            background-color: #f1f5f9;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 16px 32px;
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #0284c7;
            margin-bottom: 24px;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 24px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            margin: 0 0 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo-r.jpg') }}" alt="Logo SIRA">
            <h1>SIRA RT/RW Digital</h1>
        </div>
        
        <div class="content">
            <h2>Verifikasi Kode OTP</h2>
            <p>{{ $message }}</p>
            
            <div class="otp-box">
                {{ $otpCode }}
            </div>
            
            <p style="font-size: 14px; color: #64748b;">
                Kode OTP ini hanya berlaku selama 5 menit.<br>
                Jika Anda tidak merasa melakukan aktivitas ini, abaikan email ini.
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SIRA RT/RW Digital. Hak Cipta Dilindungi.</p>
            <p style="font-size: 12px;">Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
