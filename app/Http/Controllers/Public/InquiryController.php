<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $name = $request->input('name') ?: $request->input('full_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $projectType = $request->input('project_type', 'General Project');
        $subject = $request->input('subject') ?: "Project Inquiry: {$projectType}";
        $message = $request->input('message') ?: $request->input('details');

        if (!$name || !$email || !$message) {
            return back()->withErrors([
                'name' => !$name ? 'Name is required.' : null,
                'email' => !$email ? 'Email is required.' : null,
                'message' => !$message ? 'Message details are required.' : null,
            ]);
        }

        Inquiry::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'status' => 'new'
        ]);

        return back()->with('success', 'Thank you. Your inquiry has been transmitted to our engineering team.');
    }
}
