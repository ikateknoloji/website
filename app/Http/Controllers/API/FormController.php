<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|max:255',
            'full_name' => 'required|max:255',
            'activity_area' => 'required|max:255',
            'company_motto' => 'required|max:255',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email',
            'project_information' => 'required',
        ]);

        Form::create($validatedData);

        return response()->json([
            'message' => 'Form submitted successfully'
        ], 201);
    }
}
