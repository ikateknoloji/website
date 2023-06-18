<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ServiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceProducts = ServiceProduct::orderBy('created_at')->get();
        return response()->json($serviceProducts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image',
        ]);


     $imagePath = $request->file('image')->store('service_product_images', 'public');
     $imageUniqueName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
     Storage::disk('public')->move($imagePath, 'service_product_images/' . $imageUniqueName);

     $serviceProduct = ServiceProduct::create([
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
        'image' => $imageUniqueName,
     ]);

     return response()->json($serviceProduct, 201);
    }

    public function show(string $id)
    {

        $serviceProduct = ServiceProduct::findOrFail($id);
        $servicePackages = $serviceProduct->servicePackages->load('packageFeatures');

        return response()->json($servicePackages, 200);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'image' => 'sometimes|nullable|image',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $serviceProduct = ServiceProduct::findOrFail($id);

        $serviceProduct->title = $request->input('title');
        $serviceProduct->description = $request->input('description');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            $extension = $image->getClientOriginalExtension();
            $imageUniqueName = uniqid() . '.' . $extension;
    
            $image->storeAs('public/service_product_images', $imageUniqueName);
    
            Storage::disk('public')->delete('service_product_images/' . $serviceProduct->image);
    
            $serviceProduct->image = $imageUniqueName;
        }
    
        $serviceProduct->save();

        return response()->json($serviceProduct);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $serviceProduct = ServiceProduct::findOrFail($id);

        Storage::disk('public')->delete('service_product_images/' . $serviceProduct->image);
    
        $serviceProduct->delete();
    
        return response()->json(['message' => 'Service product deleted']);
    }
      // -- --------
      // -- --------
      // -- --------
      // -- --------

    public function getServiceProducts()
    {
        $serviceProducts = ServiceProduct::select('id', 'title')->get();

        return response()->json($serviceProducts);
    }

    public function getServicePackages(Request $request, $id)
    {
        $serviceProduct = ServiceProduct::find($id);

        if (!$serviceProduct) {
            return response()->json(['error' => 'Service product not found'], 404);
        }

        $servicePackages = $serviceProduct->servicePackages;

        return response()->json($servicePackages);
    }
}
