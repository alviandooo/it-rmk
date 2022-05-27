<!DOCTYPE html>
<html>
<head>
    <title>How to Generate QR Code in Laravel 8</title>
</head>
<body>
<div class="visible-print text-center">
    {{-- {!! QrCode::size(150)->merge('assets/images/LOGO-RMKE.jpg', .3, true)->generate($kode); !!} --}}
    <img style="width: 150px;" src="data:image/png;base64, {!! $qrcode !!}">

     
</div>
    
</body>
</html>