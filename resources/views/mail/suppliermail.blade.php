
<style>html,body { padding: 0; margin:0; }</style>
<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
		<tbody>

			<tr>
				<td align="left" valign="center">
					<div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">
						<!--begin:Email content-->
						<div style="padding-bottom: 30px; font-size: 17px;">
							<strong>Kepada, {{$data['to']}} </strong>
						</div>
						<div style="padding-bottom: 30px">Diinformasikan bahwa BAST Dengan No : <strong> {{$data['no']}} </strong> Telah selesai melalui proses approval.<br><br>

							Note : <br>{{$data['note']}}<br>

							Demikian yang dapat kami sampaikan, terima kasih atas perhatiannya.</div>
						<div style="padding-bottom: 10px">Terimaksih
                            <br>
                            <br>
                            <br>
                            {{-- <p><i>Sent by: </i></p> --}}
                        </div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
