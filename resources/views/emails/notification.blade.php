<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
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
            background-color: #0f172a;
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
            padding: 32px 24px;
        }
        .content p {
            margin: 0 0 16px 0;
            font-size: 16px;
        }
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        .button {
            display: inline-block;
            background-color: #0f172a;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 32px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.3);
            transition: all 0.2s ease;
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
            {{-- We use the full URL for email images --}}
            <img src="{{ asset('images/logo-r.jpg') }}" alt="Logo SIRA">
            <h1>SIRA RT/RW Digital</h1>
        </div>
        
        <div class="content">
            <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 16px;">{{ $title }}</h2>
            
            <p>{{ $contentMessage }}</p>

            @if(!empty($url))
                <div class="button-container">
                    <a href="{{ $url }}" class="button">Lihat Detail</a>
                </div>
                
                <p style="font-size: 14px; color: #64748b; margin-top: 32px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                    Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:<br>
                    <a href="{{ $url }}" style="color: #0f172a; word-break: break-all;">{{ $url }}</a>
                </p>
            @endif
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SIRA RT/RW Digital. Hak Cipta Dilindungi.</p>
            <p style="font-size: 12px;">Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
