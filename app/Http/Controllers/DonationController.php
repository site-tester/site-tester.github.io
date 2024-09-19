<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        dd($request->all());
        // Validate the form input
        $validator = Validator::make($request->all(), [
            'donation_type' => 'required|string',
            'donation-basket-array' => 'required|array',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required|date_format:H:i',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle the donation basket
        $donationBasket = $request->input('donation-basket-array');

        // Handle file uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/donations', 'public');
                $imagePaths[] = $path;
            }
        }

        // Save the donation details to the database (assuming you have a Donation model)
        // Example (you need to create the models and database migrations):

        $donation = Donation::create([
            'type' => $request->donation_type,
            'items' => json_encode($donationBasket),
            'schedule_date' => $request->schedule_date,
            'schedule_time' => $request->schedule_time,
            'images' => json_encode($imagePaths)
        ]);

        // Return success response
        return redirect()->back()->with('success', 'Donation submitted successfully!');
    }
}
