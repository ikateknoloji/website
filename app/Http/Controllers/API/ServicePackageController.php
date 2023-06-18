<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PackageFeature;
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_product_id' => 'required|exists:service_products,id',
            'name' => 'required',
            'subheading' => 'required',
            'price' => 'required',
            'package_features' => 'required|array',
            'package_features.*.icon' => 'required',
            'package_features.*.text' => 'required',
        ]);
    
        $servicePackage = ServicePackage::create([
            'service_product_id' => $validatedData['service_product_id'],
            'name' => $validatedData['name'],
            'subheading' => $validatedData['subheading'],
            'price' => $validatedData['price'],
        ]);
    
        $packageFeatures = collect($validatedData['package_features'])
            ->map(function ($featureData) use ($servicePackage) {
                return [
                    'service_package_id' => $servicePackage->id,
                    'icon' => $featureData['icon'],
                    'text' => $featureData['text'],
                ];
            });
    
        $servicePackage->packageFeatures()->createMany($packageFeatures);
    
        $servicePackage->refresh();

        $servicePackage->packageFeatures->each(function ($packageFeature) {
            $packageFeature->setVisible(['id', 'service_package_id', 'icon', 'text']);
        });
    
        return response()->json($servicePackage->only(['id', 'service_product_id', 'name', 'subheading', 'price', 'packageFeatures']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required',
            'subheading' => 'sometimes|required',
            'price' => 'sometimes|required',
        ]);
    
        $servicePackage = ServicePackage::findOrFail($id);
    
        $servicePackage->update($validatedData);
    
        return response()->json($servicePackage, 200);
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicePackage = ServicePackage::findOrFail($id);
    
        // İlişkili PackageFeature modellerini de silmek isterseniz bu satırı ekleyebilirsiniz
        // $servicePackage->packageFeatures()->delete();
    
        $servicePackage->delete();
    
        return response()->json(['message' => 'ServicePackage deleted successfully'], 200);
    }
}
