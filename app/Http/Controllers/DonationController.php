<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\DonationReceived;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the form input
        $validator = Validator::make($request->all(), [
            'barangay' => 'required|exists:barangays,id',
            'donation_type' => 'required|string',
            'donation-basket-array' => 'required',
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


        $brgyRepId = Barangay::find($request->barangay);
        $donation = Donation::create([
            'donor_id' => Auth::id(),
            'barangay_id' => $brgyRepId->barangay_rep_id,
            'type' => $request->donation_type,
            'items' => $donationBasket,
            'donation_date' => $request->schedule_date,
            'donation_time' => $request->schedule_time,
            'images' => $imagePaths,
            'status' => 'Pending Approval'
        ]);

        // Notification Driver
        $brgy = User::find($brgyRepId->barangay_rep_id);
        $brgy->notify(new DonationReceived($donation));

        // Return success response
        return view('main.confirmation_page')->with('success', 'Donation submitted successfully!');
    }

    public function myDonation()
    {
        $recentDonations = Donation::where('donor_id', Auth::user()->id)->orderBy('created_at', 'desc')->limit(5)->get();
        $historyDonations = Donation::where('donor_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        if ($historyDonations->isNotEmpty()) {
            // Get the first donation's created_at time and format it
            $lastDonatedConvert = $historyDonations->first()->created_at->diffForHumans();
        } else {
            // No donations found
            $lastDonatedConvert = 'No Donations';
        }
        $lastDonated = $lastDonatedConvert;

        if ($historyDonations->isNotEmpty()) {
            // Get the first donation's created_at time and format it
            $firstDonatedConvert = $historyDonations->last()->created_at->diffForHumans();
        } else {
            // No donations found
            $firstDonatedConvert = '(Not Donated Yet)';
        }
        // $firstDonatedConvert = $historyDonations->last()->created_at;
        $firstDonated = $firstDonatedConvert;
        // $this->getHumanReadableDonationTime($firstDonatedConvert);

        $donationNotification = Auth::user()->notifications()->orderBy('created_at', 'desc')->get(); // Or whatever logic you're using to retrieve notifications
        // dd($donationNotification);
        return view('main.my_donation', compact('recentDonations', 'historyDonations', 'lastDonated', 'firstDonated', 'donationNotification'));
    }

    public function getHumanReadableDonationTime($donationDate)
    {
        // Parse the donation date into a Carbon instance
        $donationTime = Carbon::parse($donationDate);

        // Return the human-readable time difference
        return $donationTime->diffForHumans();
    }

    public function show($id)
    {
        // Find the donation by ID
        $donation = Donation::findOrFail($id);

        // Return the donation details as JSON
        return response()->json($donation);
    }

}
