<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inbox</title>
</head>
<body>
    Nama Pelapor: {{ $informer_fullname }} <br>
    Alamat Pelapor : {{ $informer_address }} <br>
    Email Pelapor : {{ $informer_email }} <br>
    No. Telp. Pelapor : {{ $informer_phone }} <br>
    <hr>
    Nama Terlapor: {{ $suspect_fullname }} <br>
    Jabatan : {{ $suspect_department }} <br>
    Satuan Kerja : {{ $suspect_division }} <br>
    <hr>
    Subject Pengaduan : {{ $subject }} <br>
    Isi Pengaduan : {{ $complaint }} <br>
</body>
</html>