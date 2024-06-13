@extends('layout.main')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
	<h2>Report Sales</h2>
</div>
<div class="row">
  	<div class="col-md-12">
	    <div class="card shadow mb-3 no-print">
	    	<div class="card-header">
	    		<h6 class="m-0 font-weight-bold text-primary">Search Form</h6>
	    	</div>
	      	<div class="card-body">
		        <form action="{{ url('report') }}" method="post" class="form-horizontal">
		        	@csrf
			        <div class="row no-gutters">
			            <div class="col-md-5">
				            <div class="form-group">
				                <div class="row">
					                <label class="col-sm-3 control-label"><b>Start Date</b></label>
					                <div class="col-sm-8">
				                    	<input type="date" class="form-control" name="start" max="{{ date('Y-m-d') }}" autofocus required>
					                </div>
				                </div>  
				            </div>  
			            </div>
			            <div class="col-md-5">
				            <div class="form-group">
				                <div class="row">
					                <label class="col-sm-3 control-label"><b>End Date</b></label>
					                <div class="col-sm-8">
					                    <input type="date" class="form-control" name="end" max="{{ date('Y-m-d') }}" required>
					                </div>
				                </div> 
				            </div> 
			            </div>
			            <div class="col-md-2">
			              <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
			            </div>
			        </div>
		        </form>
	      	</div>
	    </div>
  	</div>
  	@if(isset($transactions) && $transactions->count())
  	<div class="col-md-12">
	    <div class="card mb-5">
	    	<a href="#collapseCard" class="d-block card-header py-3 no-print" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCard">
                <h6 class="m-0 font-weight-bold text-primary">Sales Data</h6>
            </a>
            <div class="collapse show" id="collapseCard">
		      	<div class="card-body">
		      		<div class="d-flex justify-content-end mb-3">
			    		<a href="{{ url('report/export?startDate='. $startDate .'&endDate='. $endDate) }}" class="btn btn-success btn-sm mr-1 no-print"><i class="fa fa-file-excel"></i> Export Excel</a>
			    		<button type="button" name="pdf" class="btn btn-danger btn-sm no-print"><i class="fa fa-file-pdf"></i> Print</button>
		    		</div>
		    		<h3 class="print mb-3">Report Sales</h3>
		    		<p class="print text-muted mb-3">{{ date('d-m-Y', strtotime($startDate)) }} - {{ date('d-m-Y', strtotime($endDate)) }}</p>
			        <table class="table table-bordered table-hover table-striped">
			        	<thead>
			        		<tr>
			        			<th width="1%">No</th>
			        			<th>Invoice</th>
			        			<th>Date</th>
			        			<th>Customer</th>
			        			<th>Cashier</th>
			        			<th>Total</th>
			        			<th>Profit</th>
			        			<th class="text-center no-print">#</th>
			        		</tr>
			        	</thead>
			        	<tbody>
			        		@foreach($transactions as $transaction)
			        		<tr>
			        			<td>{{ $loop->iteration }}</td>
			        			<td>{{ $transaction->invoice }}</td>
			        			<td>{{ $transaction->date }}</td>
			        			<td>{{ $transaction->customer_id !== null ? $transaction->customer->name : 'Umum' }}</td>
			        			<td>{{ $transaction->user->name }}</td>
			        			<td>Rp.{{ number_format($transaction->total) }}</td>
			        			<td>Rp.{{ number_format($transaction->profit) }}</td>
			        			<td class="text-center no-print">
			        				<a href="{{ url('transaction/print/'. $transaction->id) }}" target="_blank" title="Print Receipt" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
			        			</td>
			        		</tr>
			        		@endforeach
			        	</tbody>
			        </table>
		      	</div>
		    </div>
	    </div>
  	</div>
  	@endif
</div>

<script type="text/javascript">
	const btnPdf = document.querySelector('button[name=pdf]')
	btnPdf.addEventListener('click', function(){
		window.print()
	})
</script>
@endsection