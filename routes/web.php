<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function(){
	Route::get('dashboard', function(){
		$today = Carbon::today();
		$currentYear = Carbon::now()->year;
		$monthlySales = [];
		for ($i=1; $i <= 12; $i++) { 
			$total = Transaction::whereMonth('date', $i)->whereYear('date', $currentYear)->sum('total');
			$monthlySales[] = $total;
		}
		
		return view('dashboard.index', [
			'totalProducts' => Product::count(),
			'totalCategories' => Category::count(),
			'salesToday' => Transaction::whereDate('date', $today)->sum('total'),
			'profitsToday' => Transaction::whereDate('date', $today)->sum('profit'),
			'month' => ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],
			'monthlySales' => $monthlySales
		]);
	});
	Route::get('transaction', [TransactionController::class, 'index']);
	Route::get('transaction/searchProduct', [TransactionController::class, 'searchProduct']);
	Route::post('transaction/addToCart', [TransactionController::class, 'addToCart']);
	Route::get('transaction/removeFromCart/{index}', [TransactionController::class, 'removeFromCart']);
	Route::get('transaction/emptyCart', [TransactionController::class, 'emptyCart']);
	Route::post('transaction/checkout', [TransactionController::class, 'checkout']);
	Route::get('transaction/print/{transaction}', [TransactionController::class, 'print']);
	Route::get('logout', [AuthController::class, 'logout']);
});

Route::middleware('admin')->group(function(){
	Route::resource('category', CategoryController::class)->except('show', 'edit', 'create');
	Route::resource('product', ProductController::class)->except('show');
	Route::post('product/import', [ProductController::class, 'import']);
	Route::resource('customer', CustomerController::class)->except('show', 'edit', 'create');
	Route::get('report', [ReportController::class, 'index']);
	Route::post('report', [ReportController::class, 'filterSale']);
	Route::get('report/export', [ReportController::class, 'export']);
	Route::resource('user', UserController::class)->except('show', 'edit', 'create');
});