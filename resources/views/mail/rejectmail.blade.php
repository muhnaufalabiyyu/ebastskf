<style>html,body { padding: 0; margin:0; }</style>
<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
		<tbody>
			{{-- <tr>
				<td align="center" valign="center" style="text-align:center; padding: 40px">
					<a href="{{ config('app.url') }}" rel="noopener" target="_blank">
						<img alt="Logo" src="{{ asset('images/RIMA-Logo-dark.png') }}" class="h-60px h-lg-75px" />
					</a>
				</td>
			</tr> --}}
			<tr>
				<td align="left" valign="center">
					<div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">
						<!--begin:Email content-->
						<div style="padding-bottom: 30px; font-size: 17px;">
							<strong>Dear Department : {{$data['to']}}</strong>
						</div>
						<div style="padding-bottom: 30px">Diinformasikan bahwa dokumen BAST Dengan No : <strong>{{$data['no']}}</strong>, diperlukan REVISI dan menunggu approval kembali.

							Silahkan klik <a href="{{route('approval')}}">Link</a> <br><br>

							Note :  {{$data['note']}} <br><br>

							Demikian yang dapat kami sampaikan, terima kasih atas perhatiannya.</div>
						<div style="padding-bottom: 10px">Terimakasih
                            <br>
                            <br>
                        </div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>


{{-- <!DOCTYPE html>
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
</html> --}}
