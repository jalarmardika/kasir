@extends('layout.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h2>Dashboard</h2>
</div>
<div class="row">
	<div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="card-body-icon mr-3">
            <i class="fas fa-list-alt fa-3x text-gray-300"></i>
          </div>
          <h5 class="card-title text-xs font-weight-bold text-primary text-uppercase mb-1">Categories</h5>
          <div class="font-weight-bold text-gray-800 text-primary">
            <p>{{ number_format($totalCategories) }}</p>
          </div>
        </div>  
      </div>     
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="card-body-icon mr-3">
            <i class="fa fa-box fa-3x text-gray-300"></i>
          </div>
          <h5 class="card-title text-xs font-weight-bold text-success text-uppercase mb-1">Products</h5>
          <div class="font-weight-bold text-gray-800 text-success">
            <p>{{ number_format($totalProducts) }}</p>
          </div>
        </div>  
      </div>     
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="card-body-icon mr-3">
            <i class="fa fa-shopping-cart fa-3x text-gray-300"></i>
          </div>
          <h5 class="card-title text-xs font-weight-bold text-danger text-uppercase mb-1">Sales Today</h5>
          <div class="font-weight-bold text-gray-800 text-danger">
            <p>Rp.{{ number_format($salesToday) }}</p>
          </div>
        </div>  
      </div>     
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="card-body-icon mr-3">
            <i class="fas fa-money-bill fa-3x text-gray-300"></i>
          </div>
          <h5 class="card-title text-xs font-weight-bold text-warning text-uppercase mb-1">Profits Today</h5>
          <div class="font-weight-bold text-gray-800 text-warning">
            <p>Rp.{{ number_format($profitsToday) }}</p>
          </div>
        </div>  
      </div>     
    </div>

    <div class="col-md-12">
      <div class="card shadow mb-5">
          <!-- Card Header - Accordion -->
          <a href="#collapseCardPendapatan" class="d-block card-header py-3" data-toggle="collapse"
              role="button" aria-expanded="true" aria-controls="collapseCardPendapatan">
              <h6 class="m-0 font-weight-bold text-primary">Monthly Sales Graph</h6>
          </a>
          <!-- Card Content - Collapse -->
          <div class="collapse show" id="collapseCardPendapatan">
              <div class="card-body">
                </br>
                <div style="width: 100%;height: 100%">
                  <canvas id="salesChart"></canvas>
                </div>
              </div>
          </div>
      </div>
    </div>
</div>

<script src="{{ url('startbootstrap-sb-admin-2-gh-pages/vendor/chart.js/Chart.min.js') }}"></script>
<script type="text/javascript">
  var ctx = document.getElementById("salesChart").getContext('2d');
  var salesChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($month) !!},
      datasets: [{
        label: 'Total ',
        data: {!! json_encode($monthlySales) !!},
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        borderWidth: 3
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true
          }
        }]
      }
    },

  });
</script>
@endsection