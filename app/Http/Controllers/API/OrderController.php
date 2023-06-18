<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Order;
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_package_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'name' => 'required',
            'field' => 'required',
            'full_name' => 'required',
            'motto' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email',
            'establishment_year' => 'required|integer',
            'about' => 'required',
            'project_content' => 'required',
        ],[
            'required' => 'Zorunlu alan gereklidir.',
            'email' => 'Geçerli bir e-posta adresi giriniz.',
            'integer' => 'Lütfen alan bir sayı olmalıdır.',
            'regex' => 'Telefon alanı için geçerli bir format giriniz.',
        ]);
    
        $order = Order::create(array_merge($validatedData, [
            'status' => 'pending',
            'offer_price' => ServicePackage::findOrFail($validatedData['service_package_id'])->price,
        ]));
    
        return response()->json($order, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Belirli bir siparişin bilgilerini al
        $order = Order::findOrFail($id);

        // Siparişe bağlı olan hizmet paketi bilgisini al
        $servicePackage = ServicePackage::select('name', 'price')->findOrFail($order->service_package_id);        
        $city = City::findOrFail($order->city_id);
        $district = District::findOrFail($order->district_id);
    
        $order["city"] = $city->city;
        $order["district"] = $district->district;
        $order["servicePackage"] = $servicePackage;
    
        // Sipariş ve hizmet paketi verilerini birleştir ve JSON olarak döndür
        return response()->json($order );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'service_package_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'name' => 'required',
            'field' => 'required',
            'full_name' => 'required',
            'phone' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'],
            'email' => 'required|email',
            'establishment_year' => 'nullable|integer',
            'about' => 'nullable|string',
            'project_content' => 'nullable|string',
        ]);
    
        $order = Order::findOrFail($id);
        $order->update($validatedData);
    
        return response()->json($order, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
    
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}

/**
 * 
 */