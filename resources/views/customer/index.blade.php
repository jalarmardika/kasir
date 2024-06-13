@extends('layout.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h2>Customers</h2>
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
		<div class="card shadow">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary">Data Customers</h6>
			</div>
			<div class="card-body">
				<a href="#" data-toggle="modal" data-target="#modalAdd" class="btn btn-outline-primary btn-sm mb-3">Add Customer</a>
				<table id="dataTable" class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th width="1%">No</th>
							<th>Name Customer</th>
							<th>Address</th>
							<th>No Handphone</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($customers as $customer)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $customer->name }}</td>
							<td>{{ $customer->address }}</td>
							<td>{{ $customer->no_hp }}</td>
							<td>
								<a href="#" data-toggle="modal" data-target="#modalEdit{{ $customer->id }}" class="btn btn-outline-warning btn-sm">Edit</a>
								<form action="{{ url('customer/'. $customer->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure ?')">
									@csrf
									@method('delete')
									<button type="submit" name="submit" class="btn btn-outline-danger btn-sm">Delete</button>
								</form>
							</td>
						</tr>

						<div class="modal" tabindex="-1" id="modalEdit{{ $customer->id }}">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Edit Customer</h5>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body">
										<form action="{{ url('customer/'. $customer->id) }}" method="post">
											@csrf
											@method('put')
											<div class="form-group">
												<label>Name</label>
												<input type="text" name="name" class="form-control" value="{{ $customer->name }}">
											</div>
											<div class="form-group">
												<label>Address</label>
												<textarea name="address" class="form-control">{{ $customer->address }}</textarea>
											</div>
											<div class="form-group">
												<label>No Handphone</label>
												<input type="text" name="no_hp" class="form-control" value="{{ $customer->no_hp }}">
											</div>											
											<button type="submit" name="submit" class="btn btn-primary float-right btn-sm">Update</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</tbody>
				</table>				
			</div>
		</div>
	</div>
</div>

<!-- modal add -->
<div class="modal" tabindex="-1" id="modalAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Customer</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="{{ url('customer') }}" method="post">
					@csrf
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ old('name') }}">
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea name="address" class="form-control">{{ old('address') }}</textarea>
					</div>
					<div class="form-group">
						<label>No Handphone</label>
						<input type="text" name="no_hp" class="form-control" autocomplete="off" value="{{ old('no_hp') }}">
					</div>					
					<button type="submit" name="submit" class="btn btn-primary float-right btn-sm">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection