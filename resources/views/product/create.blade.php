@extends('layout.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h2>Add Product</h2>
</div>
<div class="row">
	<div class="col-md-12">
		@if($errors->any())
		<div class="alert alert-danger">
			<button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<ul>
				@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		<div class="card shadow mb-5">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary">Form Add Product</h6>
			</div>
			<div class="card-body">
				<form action="{{ url('product') }}" method="post">
					@csrf
					<div class="form-group">
						<label>Barcode</label>
						<input type="text" name="barcode" class="form-control" autocomplete="off" value="{{ old('barcode') }}">
					</div>
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ old('name') }}">
					</div>
					<div class="form-group">
						<label>Category</label>
						<select name="category_id" class="form-control">
							<option value="">-- Select Category --</option>
							@foreach($categories as $category)
								@if($category->id == old('category_id'))
									<option value="{{ $category->id }}" selected>{{ $category->name }}</option>
								@else
									<option value="{{ $category->id }}">{{ $category->name }}</option>
								@endif
							@endforeach
						</select>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Buy Price</label>
								<input type="text" name="buy_price" class="form-control" value="{{ old('buy_price') }}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Sell Price</label>
								<input type="text" name="sell_price" class="form-control" value="{{ old('sell_price') }}">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Stock</label>
						<input type="text" name="stock" class="form-control" value="{{ old('stock') }}">
					</div>
					<div class="d-flex justify-content-end">
						<a href="{{ url('product') }}" class="btn btn-secondary text-gray btn-sm mr-1">Back</a>
						<button type="submit" name="submit" class="btn btn-primary btn-sm">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection