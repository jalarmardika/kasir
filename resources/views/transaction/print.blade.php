<!DOCTYPE html>
<html>
<head>
	<title>Cetak Struk</title>
	<style type="text/css">
		hr{
			border: 1px dashed;
		}
		*{
			color: #666;
		}
	</style>
</head>
<body>
	<div>
		<table width="500" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td align="center">
					<h3>Toko Makmur Sentosa</h3>
					Jl. Soponyono No.100 Ds. Kedungsuren Kaliwungu Selatan<br>
					No Telp. 089-758-575-3187
				</td>
			</tr>
		</table>
		<table width="500" border="0" cellpadding="1" cellspacing="0" class="mt-5">
			<tr>
				<td colspan="4"><hr class="bg-dark"></td>
			</tr>	
			<tr>
				<td>
					Pembeli : {{ $transaction->customer_id !== null ? $transaction->customer->name : 'Umum' }}
				</td>
				<td align="right">
					Kasir : {{ $transaction->user->name }}
				</td>
			</tr>
			<tr>
				<td colspan="4"><hr class="bg-dark"></td>
			</tr>
			<tr>
				<td>Invoice : {{ $transaction->invoice }}</td>
				<td align="right">Tanggal : {{ date('d-m-Y H:i:s', strtotime($transaction->date)) }}</td>
			</tr>
			<tr>
				<td colspan="4"><hr class="bg-dark"></td>
			</tr>		
		</table>
		<table width="500" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="45%">Nama Produk</td>
				<td>Harga</td>
				<td align="center">Jumlah</td>	
				<td align="right">Subtotal</td>
			</tr>
			<tr>
				<td colspan="4"><hr class="bg-dark"></td>
			</tr>	
			@foreach($transaction_details as $val)
			<tr>
				<td width="40%">{{ $val->product->name }}</td>
				<td>Rp.{{ number_format($val->price) }}</td>
				<td align="center">{{ $val->quantity }}</td>				
				<td align="right">Rp.{{ $val->sub_total }}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="4"><hr class="bg-dark"></td>
			</tr>
			<tr>
				<td align="right" colspan="3">Total : </td>
				<td align="right">  Rp.{{ number_format($transaction->total) }}</td>
			</tr>
			<tr>
				<td align="right" colspan="3">Tunai : </td>
				<td align="right">  Rp.{{ number_format($transaction->paid) }}</td>
			</tr>
			<tr>
				<td align="right" colspan="3">Kembali : </td>
				<td align="right">  Rp.{{ number_format($transaction->return) }}</td>
			</tr>
			<tr>
				<td colspan="4"><hr class="bg-dark"></td>
			</tr>
		</table>
		<table width="500" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td align="center">---Terima Kasih Atas Kunjungan Anda---</td>
			</tr>
		</table>
	</div>

	<script type="text/javascript"> 
		window.print();
	</script> 
</body>
</html>