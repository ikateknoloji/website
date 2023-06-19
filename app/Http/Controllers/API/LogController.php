<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ApiRequest;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $logs = ApiRequest::all();
        
        return response()->json($logs);
    }
}
