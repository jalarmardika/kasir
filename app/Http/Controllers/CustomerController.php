<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.index', [
            'customers' => Customer::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'no_hp' => 'required|max:20'
        ]);

        Customer::create($validatedData);
        return redirect('customer')->with('success', 'Data Saved Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'no_hp' => 'required|max:20'
        ]);

        Customer::find($customer->id)->update($validatedData);
        return redirect('customer')->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        try {
            Customer::destroy($customer->id);
            return redirect('customer')->with('success', 'Data Deleted Successfully');
        } catch (QueryException $e) {
            return redirect('customer')->with('fail', 'Data cannot be deleted because there is related transaction data');
        }
    }
}
