@extends('layout.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h2>Categories</h2>
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
		@endif

		@if(session()->has('fail'))
		<div class="alert alert-danger">
			<button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ session('fail') }}
		</div>
		@endif
		<div class="card shadow mb-5">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary">Data Categories</h6>
			</div>
			<div class="card-body">
				<a href="#" data-toggle="modal" data-target="#modalAdd" class="btn btn-outline-primary btn-sm mb-3">Add Category</a>
				<table id="dataTable" class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th width="1%">No</th>
							<th>Name Category</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($categories as $category)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $category->name }}</td>
							<td>
								<a href="#" data-toggle="modal" data-target="#modalEdit{{ $category->id }}" class="btn btn-outline-warning btn-sm">Edit</a>
								<form action="{{ url('category/'. $category->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure ?')">
									@csrf
									@method('delete')
									<button type="submit" name="submit" class="btn btn-outline-danger btn-sm">Delete</button>
								</form>
							</td>
						</tr>

						<div class="modal" tabindex="-1" id="modalEdit{{ $category->id }}">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Edit Category</h5>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body">
										<form action="{{ url('category/'. $category->id) }}" method="post">
											@csrf
											@method('put')
											<div class="form-group">
												<label>Name</label>
												<input type="text" name="name" class="form-control" maxlength="100" autocomplete="off" required value="{{ old('name', $category->name) }}">
											</div>
											<button type="submit" name="submit" class="btn btn-primary float-right btn-sm">Save</button>
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
				<h5 class="modal-title">Add Category</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="{{ url('category') }}" method="post">
					@csrf
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" maxlength="100" autocomplete="off" required>
					</div>
					<button type="submit" name="submit" class="btn btn-primary float-right btn-sm">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection