<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Mail\BulkEmail;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMailToCustomers()
    {
        $details = [
            'title' => '"Dijital Varlığınızı IKAtech ile Güçlendirin ',
            'body' => 'This is for testing email using smtp',
        ];

        $customers = Customer::all();

        foreach ($customers as $customer) {
            Mail::to($customer->email)->send(new BulkEmail($details));
        }

        return response()->json(['message' => 'Mails sent successfully'], 200);
    }

    public function sendEmail(Request $request) {
        $request->validate([
            'company_name' => 'required',
            'to' => 'required|email'
        ]);
        
        $details = [
            'company_name' => $request->company_name,
        ];
    
        Mail::to($request->to)->send(new SendMail($details));
        return response()->json(['message' => 'Mail successfully sent!'], 200);
    }
}
