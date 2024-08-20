<!DOCTYPE html>
<html>
<head>
    <title>Email Pemberitahuan Approval</title>
</head>
<body>
    <p>Dear (Atasan)</p>

    <p>
        Berikut adalah detail dari BAST yang telah di-<b>approve</b>:
    </p>

    <ul>
        <li><strong>No BAST:</strong> {{ $data->bastno }}</li>
        <li><strong>No Referensi:</strong> {{ $data->offerno }}</li>
        <li><strong>Tanggal Mulai Pekerjaan:</strong> {{ date('d/m/Y',strtotime($data->workstart)) }}</li>
        <li><strong>Tanggal Selesai Pekerjaan:</strong> {{ date('d/m/Y',strtotime($data->workend)) }}</li>
    </ul>

    <p>
        Silakan periksa lebih lanjut melalui aplikasi untuk informasi detail.
    </p>

    <p>Terima kasih,</p>

</body>
</html>
