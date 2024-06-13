@extends('layout.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h2>Transactions</h2>
</div>
<div class="row">
	<div class="col-md-12">
		@if(session()->has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ session('error') }}
		</div>
		@elseif(session()->has('transaction_id'))
		<div class="alert alert-success">
			<button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<b>Transaction Successfully ! </b> <a href="{{ url('transaction/print/'. session('transaction_id')) }}" target="_blank">Print receipt</a>
		</div>
		@endif
	</div>
	<div class="col-md-4">
		<div class="card shadow mb-3">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary">Input Product</h6>
			</div>
			<div class="card-body">
				<form id="form-product" action="{{ url('transaction/addToCart') }}" method="post">
					@csrf
					<input type="hidden" name="id"  value="{{ old('id') }}">
					<div class="form-group">
						<label for="barcode">Barcode</label>
						<input type="text" name="barcode" id="barcode" class="form-control" autofocus placeholder="Input or scan barcode">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" class="form-control" readonly>
					</div>
					<div class="form-group">
						<label for="quantity">Quantity</label>
						<input type="number" name="quantity" id="quantity" class="form-control text-center">
					</div>
					<input type="hidden" name="buy_price"  value="{{ old('buy_price') }}">
					<input type="hidden" name="sell_price"  value="{{ old('sell_price') }}">
					<button type="submit" name="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus-circle"></i> Add To Cart</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card shadow mb-5">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary">Shopping Cart</h6>
			</div>
			<div class="card-body">
				<form id="form-transaction" action="{{ url('transaction/checkout') }}" method="post">
					@csrf
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Cashier</label>
								<input type="text" name="cashier" class="form-control" readonly value="{{ auth()->user()->name }}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="customer_id">Customer (Optional)</label>
								<select name="customer_id" id="customer_id" class="form-control">
									<option value="">-- Select Customer --</option>
									@foreach($customers as $customer)
										@if(old('customer_id') == $customer->id)
											<option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
										@else
											<option value="{{ $customer->id }}">{{ $customer->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<table class="table table-bordered table-hover mt-4">
						<thead>
							<tr>
								<th>No</th>
								<th>Product Name</th>
								<th class="text-center">Price</th>
								<th class="text-center">Quantity</th>
								<th class="text-center">Sub Total</th>
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach($cart as $key => $item)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $item['name'] }}</td>
									<td class="text-right">Rp.{{ number_format($item['sell_price']) }}</td>
									<td class="text-center">{{ $item['quantity'] }}</td>
									<td class="text-right">Rp.{{ number_format($item['sub_total']) }}</td>
									<td class="text-center">
										<a href="{{ url('transaction/removeFromCart/'. $key) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					@if($cart->count())
						<a href="{{ url('transaction/emptyCart') }}" class="btn btn-danger btn-sm"><i class="fa fa-shopping-cart"></i> Empty the Cart</a>
					@endif	

					<h4 class="my-5 text-right">Grand Total : Rp.{{ number_format($total_cart) }}</h4>
					
					@if($total_cart != 0)
						<div class="row justify-content-end">
							<div class="col-md-4">
								<div class="form-group">
									<label>Paid (Rp.)</label>
									<input type="number" name="paid" class="form-control">
								</div>
								<div class="form-group">
									<label>Return (Rp.)</label>
									<input type="number" name="return" class="form-control" readonly>
								</div>
							</div>
						</div>
						<button type="submit" name="submit" class="btn btn-success btn-sm float-right mb-3"><i class="fa fa-money-bill"></i> Pay Order</button>
					@endif
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const barcode = document.getElementById('barcode')
 	const name = document.getElementById('name')
 	const quantity = document.getElementById('quantity')

	barcode.addEventListener('keyup', function(event){
		fetch("{{ url('transaction/searchProduct?barcode=') }}" + this.value)
		 .then(function(response){
		 	if (!response.ok) throw new Error("Error get data product")
		 	return response.json()
		 })
		 .then(function(data){
		 	const id = document.querySelector('input[name=id]')
		 	const buy_price = document.querySelector('input[name=buy_price]')
		 	const sell_price = document.querySelector('input[name=sell_price]')
		 	if (data.response) {
		 		const { product } = data
			 	id.value = product.id
			 	name.value = product.name
			 	buy_price.value = product.buy_price
			 	sell_price.value = product.sell_price
			 	quantity.setAttribute('max', product.stock)
			 	quantity.focus()
			} else{
				id.value = ""
				name.value = ""
				buy_price.value = ""
				sell_price.value = ""
			 	quantity.setAttribute('max', '')
			}
		 })
		 .catch(function(error){
		 	console.log(error.message)
		 })
	})

	const formInputProduct = document.getElementById('form-product')
	formInputProduct.addEventListener('submit', function(e){
		if (barcode.value == "" || name.value == "" || quantity.value == "") {
			e.preventDefault()
			alert("Form is incomplete")
		} else if (quantity.value <= 0) {
			e.preventDefault()
			alert("The quantity must be greater than 0.")
		}
	})

	const inputPaid = document.querySelector('input[name=paid]')
	inputPaid.addEventListener('keyup', function(e){
		const total = parseInt('{{ $total_cart }}')
		const paid = parseInt(this.value)
		const inputReturn = document.querySelector('input[name=return]')
		if (paid >= total) {
			inputReturn.value = paid - total
		} else {
			inputReturn.value = ""
		}
	})

	const formTransaction = document.getElementById('form-transaction')
	formTransaction.addEventListener('submit', function(event){
		const inputReturn = document.querySelector('input[name=return]')
		if (inputPaid.value == "" || inputReturn.value == "") {
			event.preventDefault()
			alert("Form is incomplete")
		}
	})
</script>
@endsection