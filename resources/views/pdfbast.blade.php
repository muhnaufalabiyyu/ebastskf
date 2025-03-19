<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Dokumen BAST</title>
    <link rel="shortcut icon" href="{{ asset('img/logoskf.svg') }}" type="image/x-icon">
    <style>
        html {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        h3 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 22px;
        }

        p {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
        }

        table,
        th,
        td {
            width: 100%;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            /* border: 1px solid black; */
        }

        .worklist,
        .worklist th,
        .worklist td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .worklist th {
            text-align: center;
        }

        .checklist {
            border: 1px solid black;
            border-collapse: collapse;
            width: 25px
        }

        .tandatangan {
            margin-top: 1cm;
            page-break-before: always;
        }

        .tandatangan td {
            width: 33.3%;
            text-align: center;
        }

        .ttd {
            height: 80px;
        }
    </style>
</head>

<body>
    <center>
        <h3>BERITA ACARA SERAH TERIMA PEKERJAAN<br><span style="font-style: italic">(Handover of Work)</span></h3>
    </center>
    <br>
    <table class="tb-info">
        @foreach ($bast as $data)
                <tr>
                    <td style="width: 300px">No. Purchase Order (PO)</td>
                    <td>: <span style="width: 380px">{{ $data->pono }}</span></td>
                </tr>
                <tr>
                    <td style="width: 300px">No. Ref. Penawaran Harga</td>
                    <td>: <span style="width: 380px">{{ $data->offerno }}</span></td>
                </tr>
                <tr>
                    <td style="width: 300px">No. Berita Acara</td>
                    <td>: <span style="width: 380px">{{ $data->bastno }}</span></td>
                </tr>
                <tr>
                    <td style="width: 300px">Tanggal Berita Acara</td>
                    <td>: <span style="width: 380px">{{ $data->bast_dt }}</span></td>
                </tr>
                <tr>
                    <td style="width: 300px">Nama Pekerjaan</td>
                    <td>: <span style="width: 380px">{{ $data->workdesc }}</span></td>
                </tr>
                <tr>
                    <td style="width: 300px">Tanggal / Periode Pekerjaan</td>
                    <td>: <span style="width: 380px">{{ $data->work_start }} sampai {{ $data->work_end }}</span></td>
                </tr>
                <tr>
                    <td style="width: 300px">Garansi Pekerjaan</td>
                    <td>: <span style="width: 380px">-</span></td>
                </tr>
            </table>
            <br>

            <table>
                <tr>
                    <td colspan="3">Yang bertanda tangan dibawah ini:</td>
                </tr>
                <tr>
                    <td style="width: 5px">1.</td>
                    <td style="width: 283px">&nbsp;&nbsp;Nama</td>
                    <td style="width: 1px">: </td>
                    <td style="width: 380px">{{ $data->createdby }}</td>
                </tr>
                @foreach ($supplier as $sp)
                    <tr>
                        <td style="width: 5px"></td>
                        <td style="width: 283px">&nbsp;&nbsp;Nama Perusahaan</td>
                        <td style="width: 1px">: </td>
                        <td style="width: 380px">{{ $sp->NamaSupplier }}</td>
                    </tr>
                    <tr>
                        <td style="width: 5px"></td>
                        <td style="width: 280px; vertical-align: top">&nbsp;&nbsp;Alamat</td>
                        <td style="width: 1px; vertical-align: top">: </td>
                        <td style="width: 380px">{{ $sp->Alamat1 }}, {{ $sp->Alamat2 }}, {{ $sp->Negara }}</td>
                    </tr>
                    <tr>
                        <td style="width: 5px"></td>
                        <td style="width: 283px">&nbsp;&nbsp;Jabatan</td>
                        <td style="width: 1px">: </td>
                        <td style="width: 380px">Direktur</td>
                    </tr>
                    <tr>
                        <td style="width: 5px"></td>
                        <td style="width: 283px">&nbsp;&nbsp;Selanjutnya disebut sebagai</td>
                        <td style="width: 1px">: </td>
                        <td style="width: 380px">Pihak Pertama</td>
                    </tr>
                @endforeach
            </table>
            <table>
                <tr>
                    <td style="width: 5px">2.</td>
                    <td style="width: 283px">&nbsp;&nbsp;Nama</td>
                    <td style="width: 1px">: </td>
                    <td style="width: 380px">{{ $userdata }}</td>
                </tr>
                <tr>
                    <td style="width: 5px"></td>
                    <td style="width: 283px">&nbsp;&nbsp;Nama Perusahaan</td>
                    <td style="width: 1px">: </td>
                    <td style="width: 380px">PT SKF Indonesia</td>
                </tr>
                <tr>
                    <td style="width: 5px"></td>
                    <td style="width: 280px; vertical-align: top">&nbsp;&nbsp;Alamat</td>
                    <td style="width: 1px; vertical-align: top">: </td>
                    <td style="width: 380px">Jl. Inspeksi Cakung Drain, Cakung Barat, Jakarta Timur 1390</td>
                </tr>
                <tr>
                    <td style="width: 5px"></td>
                    <td style="width: 283px">&nbsp;&nbsp;Jabatan</td>
                    <td style="width: 1px">: </td>
                    <td style="width: 380px">Manager</td>
                </tr>
                <tr>
                    <td style="width: 5px"></td>
                    <td style="width: 283px">&nbsp;&nbsp;Selanjutnya disebut sebagai</td>
                    <td style="width: 1px">: </td>
                    <td style="width: 380px">Pihak Kedua</td>
                </tr>
            </table>
            <p>Menerangkan bahwa telah selesai dilakukan pekerjaan:</p>
            <table class="worklist">
                <tr>
                    <th style="width: 20px">No.</th>
                    <th style="width: 380px">Deskripsi</th>
                    <th style="width: 100px">Quantity</th>
                    <th style="width: 100px">Satuan</th>
                </tr>
                @foreach ($items as $item)
                    <tr>
                        <td style="width: 20px; text-align: center">{{ $loop->iteration }}.</td>
                        <td style="width: 380px">&nbsp;&nbsp;{{ $item['name'] }}</td>
                        <td style="width: 100px; text-align: right">{{ $item['qty'] }}&nbsp;&nbsp;</td>
                        <td style="width: 100px; text-align: right">{{ $item['unit'] }}&nbsp;&nbsp;</td>
                    </tr>
                @endforeach
            </table>
            <p>dengan rincian sebagaimana terlampir (beri tanda V)</p>
            <table>
                <tr>
                    <td class="checklist">&nbsp;&nbsp;{{ empty($data->copypofile) ? 'x' : 'V' }} </td>
                    <td>&nbsp;&nbsp;Copy PO</td>
                </tr>
                <tr>
                    <td class="checklist">&nbsp;&nbsp;{{ empty($data->reportfile) ? 'x' : 'V' }} </td>
                    <td>&nbsp;&nbsp;Checklist / Service Report / Foto (before dan after)</td>
                </tr>
                <tr>
                    <td class="checklist">&nbsp;&nbsp;{{ empty($data->ehsappv) ? 'x' : 'V' }} </td>
                    <td>&nbsp;&nbsp;Safety Evaluation from EHS</td>
                </tr>
                <tr>
                    <td class="checklist">&nbsp;&nbsp; <!-- {{ empty($data->copypofile) ? 'x' : 'V' }} --> </td>
                    <td>&nbsp;&nbsp;Kesimpulan Hasil Trial</td>
                </tr>
                <tr>
                    <td class="checklist">&nbsp;&nbsp; <!-- {{ empty($data->copypofile) ? 'x' : 'V' }} --> </td>
                    <td>&nbsp;&nbsp;Bukti Diserahkan Manual Book</td>
                </tr>
                <tr>
                    <td class="checklist">&nbsp;&nbsp; <!-- {{ empty($data->copypofile) ? 'x' : 'V' }} --> </td>
                    <td>&nbsp;&nbsp;Bukti Dilakukan Training</td>
                </tr>
                <tr>
                    <td class="checklist">&nbsp;&nbsp;{{ empty($data->user_rate) ? 'x' : 'V' }} </td>
                    <td>&nbsp;&nbsp;Penilaian Hasil Kerja oleh User : {{ $data->user_rate }} of 5</td>
                </tr>
            </table>
            <p>Demikian Berita Acara Serah Terima Pekerjaan ini dibuat untuk menyatakan bahwa pekerjaan tersebut telah dapat
                diselesaikan sesuai dengan permintaan.</p>
            <table class="tandatangan">
                <tr>
                    <td style="text-align: left">Pihak Pertama</td>
                    <td></td>
                    <td style="text-align: left">Pihak Kedua</td>
                </tr>
                <tr>
                    <td style="text-align: left">yang menyerahkan,</td>
                    <td></td>
                    <td style="text-align: left">yang menerima,</td>
                </tr>
                <tr>
                    <td class="ttd"><img src="{{ public_path($signature) }}" alt="TTD Supplier" width="100px"></td>
                    <td class="ttd"></td>
                    @if ($data->status > 2)
                        <td class="ttd"><img src="{{ public_path($signatureuser) }}" alt="TTD User" width="100px"></td>
                    @else
                        <td></td>
                    @endif
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid black"></td>
                    <td></td>
                    <td style="border-bottom: 1px solid black"></td>
                </tr>
                <tr>
                    <td>{{ $data->createdby }}</td>
                    <td>Mengetahui,</td>
                    <td>{{ $data->userappv }}</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    @if ($data->status >= '4')
                        <td class="ttd"><img src="{{ public_path($signaturepurch) }}" alt="TTD Abiyyu" width="100px"></td>
                    @else
                        <td></td>
                    @endif
                    <td class="ttd"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-bottom: 1px solid black">Mochrita Lestari</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Purchasing Manager</td>
                    <td></td>
                </tr>
        @endforeach
    </table>
    <p style="font-weight: bold; font-size: 14px">Catatan: Berita acara serah terima pekerjaan dibuat 1 (satu) dengan
        kelengkapan lampiran 1 (satu)</p>
</body>

</html>