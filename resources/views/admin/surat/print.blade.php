<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar - {{ $surat->letter_type }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.6; color: #333; margin: 40px; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 15px; margin-bottom: 30px; }
        .header h1 { font-size: 16pt; margin: 0; letter-spacing: 2px; }
        .header h2 { font-size: 14pt; margin: 5px 0; }
        .header p { font-size: 10pt; margin: 3px 0; color: #555; }
        .title { text-align: center; margin: 30px 0; }
        .title h3 { font-size: 14pt; text-decoration: underline; text-transform: uppercase; letter-spacing: 3px; }
        .nomor { text-align: center; font-size: 11pt; margin-bottom: 25px; }
        .content { margin: 20px 0; }
        .content p { margin: 8px 0; text-align: justify; }
        .data-table { margin: 15px 0 15px 40px; }
        .data-table td { padding: 3px 10px; vertical-align: top; font-size: 12pt; }
        .data-table td:first-child { width: 150px; }
        .data-table td:nth-child(2) { width: 15px; }
        .footer { margin-top: 50px; }
        .sign { float: right; text-align: center; width: 250px; }
        .sign .date { margin-bottom: 60px; }
        .sign .name { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RUKUN TETANGGA</h1>
        <h2>RT. 001 / RW. 001</h2>
        <p>Jl. Contoh Alamat No. 123, Kelurahan, Kecamatan, Kota</p>
    </div>

    <div class="title">
        <h3>Surat Pengantar</h3>
    </div>
    <div class="nomor">
        No: SP/{{ str_pad($surat->id, 4, '0', STR_PAD_LEFT) }}/RT/{{ date('m/Y') }}
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Ketua RT. 001 / RW. 001 menerangkan bahwa:</p>

        <table class="data-table">
            <tr><td>Nama</td><td>:</td><td><strong>{{ $surat->user->name }}</strong></td></tr>
            <tr><td>NIK</td><td>:</td><td>{{ $surat->user->nik }}</td></tr>
            <tr><td>Alamat</td><td>:</td><td>{{ $surat->user->address ?? '-' }}</td></tr>
            <tr><td>No. Telepon</td><td>:</td><td>{{ $surat->user->phone ?? '-' }}</td></tr>
        </table>

        <p>Adalah benar warga kami yang berdomisili di wilayah RT. 001 / RW. 001 dan bermaksud mengurus <strong>{{ $surat->letter_type }}</strong> dengan keperluan:</p>

        <p style="margin-left: 40px; font-style: italic;">{{ $surat->purpose }}</p>

        <p>Demikian surat pengantar ini dibuat untuk digunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <div class="sign">
            <p class="date">{{ now()->locale('id')->isoFormat('D MMMM Y') }}</p>
            <p>Ketua RT. 001</p>
            <br><br><br>
            <p class="name">____________________</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
