<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->get();

        return response()->json($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|nullable|string|max:255',
            'full_name' => 'required|nullable|string|max:255',
            'email' => 'required|email|max:255|unique:customers',
            'phone_number' => 'required|nullable|string|max:255',
        ]);

        $customer = Customer::create($request->all());

        return response()->json(['message' => 'Customer created successfully']);
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
        $request->validate([
            'company_name' => 'sometimes|nullable|string|max:255',
            'full_name' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:customers,email,' . $customer->id,
            'phone_number' => 'sometimes|nullable|string|max:255',
        ]);

        $customer->update($request->all());

        return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
