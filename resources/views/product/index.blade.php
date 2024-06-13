@extends('layout.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h2>Products</h2>
</div>
<div class="row">
	<div class="col-md-12">
		@if(session()->has('success'))
		<div class="alert alert-success">
			<button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ session('success') }}
		</div>
		@elseif(session()->has('fail'))
		<div class="alert alert-danger">
			<button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ session('fail') }}
		</div>
		@endif

		<div class="card shadow mb-5">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary">Data Products</h6>
			</div>
			<div class="card-body">
				<a href="{{ url('product/create') }}" class="btn btn-outline-primary btn-sm mb-3">Add Product</a>
				<a href="#" data-toggle="modal" data-target="#modalImport" class="btn btn-outline-success btn-sm mb-3">Import Excel</a>
				<table id="dataTable" class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th width="1%">No</th>
							<th>Barcode</th>
							<th>Name Product</th>
							<th>Category</th>
							<th>Buy Price</th>
							<th>Sell Price</th>
							<th class="text-center">Stock</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($products as $product)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $product->barcode }}</td>
							<td>{{ $product->name }}</td>
							<td>{{ $product->category->name }}</td>
							<td>Rp.{{ number_format($product->buy_price) }}</td>
							<td>Rp.{{ number_format($product->sell_price) }}</td>
							<td class="text-center">{{ number_format($product->stock) }}</td>
							<td>
								<a href="{{ url('product/'. $product->id .'/edit') }}" class="btn btn-outline-warning btn-sm">Edit</a>
								<form action="{{ url('product/'. $product->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure ?')">
									@csrf
									@method('delete')
									<button type="submit" name="submit" class="btn btn-outline-danger btn-sm">Delete</button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>				
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" id="modalImport">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Import Excel</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="{{ url('product/import') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>File</label>
						<input type="file" name="import" class="form-control" required>
					</div>
					<button type="submit" name="submit" class="btn btn-primary float-right btn-sm">Import</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection