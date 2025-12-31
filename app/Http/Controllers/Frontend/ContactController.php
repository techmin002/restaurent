<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage; // Capital 'A' in App
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Changed from full_name to name
            'phone' => 'required|string|max:20', // Changed from phone_number to phone
            'email' => 'required|email|max:255',
            'company_name' => 'nullable|string|max:255', // Changed from company to company_name
            'message' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'Please enter your full name.',
            'phone.required' => 'Please enter your phone number.',
            'email.required' => 'Please enter your email address.',
            'message.required' => 'Please enter your message.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Store the message - match form field names with database columns
        ContactMessage::create([
            'full_name' => $request->name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'company' => $request->company_name,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}