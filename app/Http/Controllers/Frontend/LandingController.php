<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function show() {
        // Customer data
        $customers = [
            ['name' => 'فروج الزين', 'logo' => asset('logo.png')],
            ['name' => 'دجاجتي', 'logo' => asset('logo.png')],
            ['name' => 'الوجبة الشهية', 'logo' => asset('logo.png')],
            ['name' => 'على كيفك', 'logo' => asset('logo.png')],
            // Add more customers as needed
        ];

        // Statistics data
        $stats = [
            'monthly_visitors' => 10000,
            'active_ads' => 500,
            'registered_cars' => 2000,
            'satisfaction_rate' => 95,
        ];

        // App download links
        $appLinks = [
            'android' => '#', // Replace with actual Google Play link
            'ios' => '#',     // Replace with actual App Store link
        ];

        // Social media links
        $socialLinks = [
            'facebook' => '#',
            'twitter' => '#',
            'instagram' => '#',
            'linkedin' => '#',
            'youtube' => '#',
        ];

        return view('landing', compact(
            'customers',
            'stats',
            'appLinks',
            'socialLinks'
        ));
    }

    public function submit_contact_form(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Here you would typically:
        // 1. Save the contact form to database
        // 2. Send email notification
        // 3. Return success response

        return back()->with('success', 'تم استلام رسالتك بنجاح، سنتواصل معك قريباً!');
    }
}


