<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\DonationReceived;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DonationController extends Controller
{

    public function store(Request $request)
    {
        try {
            // Store donation
            $donation = new Donation();
            $donation->anonymous = $request->anonymous;
            $donation->donor_id = Auth::id();
            $donation->barangay_id = $request->barangay;
            $donation->type = $request->donation_type;
            $donation->donation_date = $request->schedule_date;
            $donation->donation_time = $request->time_slot;
            $donation->status = 'Pending Approval';
            $donation->save();

            // Decode JSON arrays
            if ($request->donation_type == "Food") {
                $foodNames = $request->food_name;
                $foodQuantities = $request->food_quantity;
                $foodExpirations = $request->food_expiration;
                $foodImages = $request->food_image; // array of uploaded food images

                for ($i = 0; $i < count($foodNames); $i++) {
                    $name = $foodNames[$i];
                    $quantity = $foodQuantities[$i];
                    $expiration = Carbon::createFromFormat('m/d/Y', $foodExpirations[$i]);
                    $image = $foodImages[$i]; // Handle image upload logic here

                    // Save the food donation item
                    DonationItem::create([
                        'donation_id' => $donation->id,
                        'item_name' => $name,
                        'quantity' => $quantity,
                        'expiration_date' => $expiration,
                        'image_path' => $image->store('uploads/donations'),
                    ]);
                }
            } elseif ($request->donation_type == "NonFood") {
                $foodNames = $request->nonfood_name;
                $foodQuantities = $request->nonfood_quantity;
                $foodCondition = $request->nonfood_condition;
                $foodImages = $request->nonfood_image; // array of uploaded nonfood images

                for ($i = 0; $i < count($foodNames); $i++) {
                    $name = $foodNames[$i];
                    $quantity = $foodQuantities[$i];
                    $condition = $foodCondition[$i];
                    $image = $foodImages[$i]; // Handle image upload logic here

                    // Save the food donation item
                    DonationItem::create([
                        'donation_id' => $donation->id,
                        'item_name' => $name,
                        'quantity' => $quantity,
                        'condition' => $condition,
                        'image_path' => $image->store('uploads/donations'),
                    ]);
                }
            } elseif ($request->donation_type == "Medical") {
                $foodNames = $request->medical_name;
                $foodQuantities = $request->medical_quantity;
                $foodCondition = $request->medical_condition;
                $foodImages = $request->medical_image; // array of uploaded nonfood images

                for ($i = 0; $i < count($foodNames); $i++) {
                    $name = $foodNames[$i];
                    $quantity = $foodQuantities[$i];
                    $condition = $foodCondition[$i];
                    $image = $foodImages[$i]; // Handle image upload logic here

                    // Save the food donation item
                    DonationItem::create([
                        'donation_id' => $donation->id,
                        'item_name' => $name,
                        'quantity' => $quantity,
                        'condition' => $condition,
                        'image_path' => $image->store('uploads/donations'),
                    ]);
                }
            }

            return response()->json(['success' => true, 'redirect_url' => route('donation.confirmation.page')]);
            // $toSee = $request->food_name;
            // return response()->json($toSee);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function donationConfimationView()
    {
        return view('main.confirmation_page');
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

        $barangays = Barangay::all();

        $donationNotification = Auth::user()->notifications()->orderBy('created_at', 'desc')->get(); // Or whatever logic you're using to retrieve notifications

        $firstDonationYear = Donation::query()
            ->orderBy('created_at', 'asc') // Assuming 'donation_date' is the date field
            ->value(DB::raw('YEAR(donation_date)')) ?? now()->year;
        // dd($donationNotification);
        return view('main.my_donation', compact('recentDonations', 'historyDonations', 'lastDonated', 'firstDonated', 'donationNotification', 'barangays', 'firstDonationYear'));
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
        $donation = Donation::with('donationItems')->findOrFail($id);

        $data = [
            'id' => $donation->id,
            'created_at' => $donation->created_at,
            'status' => $donation->status,
            'items' => $donation->donationItems, // Assuming donationItems is the relationship name
        ];

        // Return the donation details as JSON
        return response()->json($data);
    }

}
