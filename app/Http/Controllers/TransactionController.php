<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function index()
    {
  		return view('transaction.index', [
  			'cart' => collect(Session::get('cart', [])),
  			'total_cart' => $this->getTotalCart(),
  			'customers' => Customer::latest()->get()
  		]);
    }

    public function searchProduct(Request $request)
    {
    	$product = Product::where('barcode', $request->barcode)->get();
    	if ($product->count()) {
    		return response()->json([
	    		'response' => true,
	    		'product' => $product->first()
	    	]);
    	} else {
    		return response()->json([
	    		'response' => false
	    	]);
    	}
    }

    public function addToCart(Request $request)
    {
    	$cart = Session::get('cart', []);
    	$cart[] = [
    		'id' => $request->id,
    		'name' => $request->name,
    		'buy_price' => $request->buy_price,
    		'sell_price' => $request->sell_price,
    		'quantity' => $request->quantity,
    		'sub_total' => $request->sell_price * $request->quantity
    	];

    	Session::put('cart', $cart);
    	return redirect('transaction');
    }

    public function getTotalCart()
    {
    	$cart = Session::get('cart', []);
    	$total = 0;
    	foreach ($cart as $value) {
    		$total += $value['sub_total'];
    	}
    	return $total;
    }

    public function getTotalProfit()
    {
    	$cart = Session::get('cart', []);
    	$sub_total_buy_price = 0;
    	foreach ($cart as $value) {
    		$sub_total_buy_price += $value['buy_price'] * $value['quantity'];
    	}

    	$profit = $this->getTotalCart() - $sub_total_buy_price;
    	return $profit;
    }

    public function removeFromCart($index)
    {
    	$cart = Session::get('cart', []);
    	if (isset($cart[$index])) {
    		unset($cart[$index]);
    		Session::put('cart', $cart);
    	}
    	return redirect('transaction');
    }

    public function emptyCart()
    {
    	Session::forget('cart');
    	return redirect('transaction');
    }

    public function checkout(Request $request)
    {
    	$transaction = new Transaction();
    	if ($request->customer_id) {
    		$transaction->customer_id = $request->customer_id;
    	}
    	$transaction->user_id = auth()->user()->id;
    	$transaction->invoice = 'INV-' . mt_rand(1,5) . time();
    	$transaction->profit = $this->getTotalProfit();
    	$transaction->total = $this->getTotalCart();
    	$transaction->paid = $request->paid;
    	$transaction->return = $request->return;
    	$transaction->save();

    	$cart = Session::get('cart', []);
    	foreach ($cart as $item) {
    		$transactionDetail = new TransactionDetail([
    			'transaction_id' => $transaction->id,
    			'product_id' => $item['id'],
    			'price' => $item['sell_price'],
    			'quantity' => $item['quantity'],
    			'sub_total' => $item['sub_total']
    		]);
    		$transactionDetail->save();

    		$product = Product::find($item['id']);
    		$stock = $product->stock;
    		$updateStock = $stock - $item['quantity'];
    		$product->update(['stock' => $updateStock]);
    	}

    	Session::forget('cart');
    	return redirect('transaction')->with('transaction_id', $transaction->id);
    }

    public function print(Transaction $transaction)
    {
    	return view('transaction.print', [
    		'transaction' => $transaction,
	    	'transaction_details' => TransactionDetail::where('transaction_id', $transaction->id)->get()
    	]);
    }
}
