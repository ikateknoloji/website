<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PackageFeature;
use Illuminate\Http\Request;

class PackageFeatureController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_package_id' => 'required|exists:service_packages,id',
            'icon' => 'required',
            'text' => 'required',
        ]);

        $packageFeature = PackageFeature::create($validatedData);

        return response()->json($packageFeature, 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'icon' => 'sometimes|required',
            'text' => 'sometimes|required',
        ]);
    
        $packageFeature = PackageFeature::findOrFail($id);
    
        $packageFeature->update($validatedData);
    
        return response()->json($packageFeature, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $packageFeature = PackageFeature::findOrFail($id);
    
        $packageFeature->delete();
    
        return response()->json(['message' => 'PackageFeature deleted successfully'], 200);
    }
}
