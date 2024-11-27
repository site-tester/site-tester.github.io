<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\DisasterRequest;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\Notification;
use App\Models\RequestDonation;
use App\Models\User;
use App\Notifications\DonationReceived;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DonationController extends Controller
{

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'anonymous' => 'required|boolean',
    //         'barangay' => 'required|exists:barangays,id',
    //         'donation_type' => 'required|array',
    //         'schedule_date' => 'required|date',
    //         'time_slot' => 'required|string',
    //         'food_name.*' => 'nullable|string',
    //         'food_quantity.*' => 'nullable|integer|min:1',
    //         'food_expiration.*' => 'nullable|date_format:m/d/Y',
    //         'food_image.*' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
    //         'nonfood_name.*' => 'nullable|string',
    //         'nonfood_quantity.*' => 'nullable|integer|min:1',
    //         'nonfood_condition.*' => 'nullable|string',
    //         'nonfood_image.*' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
    //         'medical_name.*' => 'nullable|string',
    //         'medical_quantity.*' => 'nullable|integer|min:1',
    //         'medical_condition.*' => 'nullable|date_format:m/d/Y',
    //         'medical_image.*' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
    //     ]);

    //     try {
    //         // Store donation
    //         $donation = new Donation();
    //         $donation->anonymous = $request->anonymous;
    //         $donation->donor_id = Auth::id();
    //         $donation->barangay_id = $request->barangay;
    //         $donation->type = $request->donation_type;
    //         $donation->donation_date = $request->schedule_date;
    //         $donation->donation_time = $request->time_slot;
    //         $donation->status = 'Pending Approval';
    //         $donation->save();

    //         // Decode JSON arrays
    //         if ($request->donation_type == "Food") {
    //             $foodNames = $request->food_name;
    //             $donationType = $request->donation_type;
    //             $foodQuantities = $request->food_quantity;
    //             $foodExpirations = $request->food_expiration;
    //             $foodImages = $request->food_image; // array of uploaded food images

    //             for ($i = 0; $i < count($foodNames); $i++) {
    //                 $name = $foodNames[$i];
    //                 $quantity = $foodQuantities[$i];
    //                 $expiration = Carbon::createFromFormat('m/d/Y', $foodExpirations[$i]);
    //                 $image = $foodImages[$i]; // Handle image upload logic here

    //                 // Save the food donation item
    //                 DonationItem::create([
    //                     'donation_id' => $donation->id,
    //                     'donation_type' => $donationType,
    //                     'item_name' => $name,
    //                     'quantity' => $quantity,
    //                     'expiration_date' => $expiration,
    //                     'image_path' => $image->store('uploads/donations', 'public'),
    //                 ]);

    //             }
    //         }
    //         if ($request->donation_type == "NonFood") {
    //             $nonfoodNames = $request->nonfood_name;
    //             $donationType = $request->donation_type;
    //             $nonfoodQuantities = $request->nonfood_quantity;
    //             $nonfoodCondition = $request->nonfood_condition;
    //             $nonfoodImages = $request->nonfood_image; // array of uploaded nonfood images

    //             for ($i = 0; $i < count($nonfoodNames); $i++) {
    //                 $name = $nonfoodNames[$i];
    //                 $quantity = $nonfoodQuantities[$i];
    //                 $condition = $nonfoodCondition[$i];
    //                 $image = $nonfoodImages[$i]; // Handle image upload logic here

    //                 // Save the food donation item
    //                 DonationItem::create([
    //                     'donation_id' => $donation->id,
    //                     'donation_type' => $donationType,
    //                     'item_name' => $name,
    //                     'quantity' => $quantity,
    //                     'condition' => $condition,
    //                     'image_path' => $image->store('uploads/donations', 'public'),
    //                 ]);
    //             }
    //         }
    //         if ($request->donation_type == "Medical") {
    //             $medicineNames = $request->medical_name;
    //             $donationType = $request->donation_type;
    //             $medicineQuantities = $request->medical_quantity;
    //             $medicineCondition = $request->medical_condition;
    //             $medicineImages = $request->medical_image; // array of uploaded nonfood images

    //             for ($i = 0; $i < count($medicineNames); $i++) {
    //                 $name = $medicineNames[$i];
    //                 $quantity = $medicineQuantities[$i];
    //                 $condition = Carbon::createFromFormat('m/d/Y', $medicineCondition[$i]);
    //                 $image = $medicineImages[$i]; // Handle image upload logic here

    //                 // Save the food donation item
    //                 DonationItem::create([
    //                     'donation_id' => $donation->id,
    //                     'donation_type' => $donationType,
    //                     'item_name' => $name,
    //                     'quantity' => $quantity,
    //                     'expiration_date' => $condition,
    //                     'image_path' => $image->store('uploads/donations', 'public'),
    //                 ]);
    //             }
    //         }

    //         return response()->json(['success' => true, 'redirect_url' => route('donation.confirmation.page')]);
    //     } catch (\Exception $e) {
    //         Log::error('Donation error: ' . $e->getMessage());
    //         return response()->json(['error' => 'Something went wrong'], 500);
    //     }
    // }

    public function store(Request $request)
    {

        $request['anonymous'] = $request['anonymous'] == 1 ? true : false;
        $request['donation_type'] = json_decode($request['donation_type']);

        // return response()->json($request->all());

        try {
            // Start database transaction
            DB::beginTransaction();

            // Save donation
            $donation = Donation::create([
                'anonymous' => $request['anonymous'],
                'donor_id' => Auth::id(),
                'barangay_id' => $request['barangay'],
                'type' => json_encode($request['donation_type']),
                'donation_date' => $request['schedule_date'],
                'donation_time' => $request['time_slot'],
                'status' => 'Pending Approval',
            ]);

            // Handle Food Donations
            if (in_array("Food", $request['donation_type'])) {
                foreach ($request->food_name as $index => $name) {
                    DonationItem::create([
                        'donation_id' => $donation->id,
                        'donation_type' => 'Food',
                        'item_name' => $name,
                        'quantity' => $request->food_quantity[$index],
                        'expiration_date' => Carbon::createFromFormat('m/d/Y', $request->food_expiration[$index]),
                        'image_path' => $request->hasFile("food_image.$index")
                            ? $request->file("food_image.$index")->store('uploads/donations', 'public')
                            : null,
                    ]);
                }
            }

            // Handle Non-Food Donations
            if (in_array("NonFood", $request['donation_type'])) {
                foreach ($request->nonfood_name as $index => $name) {
                    DonationItem::create([
                        'donation_id' => $donation->id,
                        'donation_type' => 'NonFood',
                        'item_name' => $name,
                        'quantity' => $request->nonfood_quantity[$index],
                        'condition' => $request->nonfood_condition[$index],
                        'image_path' => $request->hasFile("nonfood_image.$index")
                            ? $request->file("nonfood_image.$index")->store('uploads/donations', 'public')
                            : null,
                    ]);
                }
            }

            // Handle Medical Donations
            if (in_array("Medical", $request['donation_type'])) {
                foreach ($request->medical_name as $index => $name) {
                    DonationItem::create([
                        'donation_id' => $donation->id,
                        'donation_type' => 'Medical',
                        'item_name' => $name,
                        'quantity' => $request->medical_quantity[$index],
                        'expiration_date' => Carbon::createFromFormat('m/d/Y', $request->medical_condition[$index]),
                        'image_path' => $request->hasFile("medical_image.$index")
                            ? $request->file("medical_image.$index")->store('uploads/donations', 'public')
                            : null,
                    ]);
                }
            }

            DB::commit(); // Commit transaction
            return response()->json(['success' => true, 'redirect_url' => route('donation.confirmation.page')]);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction
            Log::error('Donation error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function donationConfimationView()
    {
        return view('main.confirmation_page');
    }

    public function myDonation()
    {
        $recentDonations = Donation::where('donor_id', Auth::user()->id)->whereIn('status', ['Pending Approval', 'Approved', 'Recieved'])->orderBy('created_at', 'desc')->limit(5)->get();
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

    public function myDonationNotification()
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
        return view('main.my_donation_notification', compact('recentDonations', 'historyDonations', 'lastDonated', 'firstDonated', 'donationNotification', 'barangays', 'firstDonationYear'));
    }

    public function myDonationHistory()
    {
        $recentDonations = Donation::where('donor_id', Auth::user()->id)->orderBy('created_at', 'desc')->limit(5)->get();
        $historyDonations = Donation::where('donor_id', Auth::user()->id)->whereIn('status', ['Distributed', 'Rejected'])->orderBy('created_at', 'desc')->get();

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
        return view('main.my_donation_history', compact('recentDonations', 'historyDonations', 'lastDonated', 'firstDonated', 'donationNotification', 'barangays', 'firstDonationYear'));
    }

    public function myDonationTransparency()
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
        return view('main.my_donation_transparency', compact('recentDonations', 'historyDonations', 'lastDonated', 'firstDonated', 'donationNotification', 'barangays', 'firstDonationYear'));
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
            'approvedBy' => $donation->approved_by,
            'receivedBy' => $donation->received_by,
            'distributedBy' => $donation->distributed_by,
            'remarks' => $donation->remarks,
            'proof' => $donation->proof_document,
            'items' => $donation->donationItems, // Assuming donationItems is the relationship name
        ];

        // Return the donation details as JSON
        return response()->json($data);
    }

    public function showReceipt($id)
    {

        // Find the donation by ID with related data
        $donation = Donation::with(['donationItems', 'donor', 'barangay', 'donationItems'])->findOrFail($id);
        // Separate the items by type
        $foodItems = $donation->donationItems->where('donation_type', 'Food');
        $nonfoodItems = $donation->donationItems->where('donation_type', 'Non-Food');
        $medicineItems = $donation->donationItems->where('donation_type', 'Medical');

        // Build the response data
        $data = [
            'id' => $donation->id,
            'created_at' => $donation->created_at,
            'anonymous' => $donation->anonymous == 1 ? true : false,
            'name' => $donation->anonymous == 0 ? 'Anonymous' : $donation->donor->name,
            'contactNumber' => $donation->anonymous == 0 ? null : $donation->donor->profile->contact_number,
            'address' => $donation->anonymous == 0 ? null : $donation->donor->profile->address,
            'barangay' => $donation->barangay->name,
            'dropOffDate' => $donation->donation_date,
            'dropOffTime' => $donation->donation_time,
            'foodItems' => $foodItems->values(),
            'nonfoodItems' => $nonfoodItems->values(),
            'medicalItems' => $medicineItems->values(),
            'approvedBy' => $donation->approved_by ?? 'Not Approved', //$donation->approved_by
        ];

        // Return the donation details as JSON
        return response()->json($data);
    }


    public function viewDonationRequest()
    {
        $donationRequest = DisasterRequest::where('status', 'Approved')
            ->orderBy('vulnerability', 'desc') // Order by vulnerability
            ->paginate(3, ['*'], 'donationRequestPage');

        $donationActiveRequest = DisasterRequest::where('status', 'Approved')
            ->orderBy('vulnerability', 'desc') // Order by vulnerability
            ->orderBy('affected_family', 'desc') // Order by affected families
            ->paginate(10, ['*'], 'donationActiveRequestPage');

        $donationDoneRequest = DisasterRequest::onlyTrashed()->whereNotNull('deleted_at')
            ->orderBy('vulnerability', 'desc')  // Order by vulnerability
            ->orderBy('affected_family', 'desc') // Order by affected families
            ->paginate(10, ['*'], 'donationDoneRequestPage');

            // dd($donationActiveRequest);
        return view('main.donation_request', compact('donationRequest', 'donationActiveRequest', 'donationDoneRequest'));
    }

    public function filter(Request $request)
    {
        // Start with the basic query for approved requests
        $query = DisasterRequest::where('status', 'Approved');

        // Apply filters based on impact level
        if ($request->impactLevel && $request->impactLevel !== 'all') {
            $query->where('vulnerability', $request->impactLevel);
        }

        // Apply filters based on disaster type
        if ($request->disasterType && $request->disasterType !== 'all') {
            // Get the filtered data
            $getQuery = $query->get();

            // Apply the manipulation and filtering in the loop
            $filteredRequests = $getQuery->filter(function ($item) use ($request) {
                // Get the raw disaster_type value
                $rawValue = stripslashes($item->disaster_type);

                // Trim the extra quotes
                $cleanValue = trim($rawValue, '"');

                // Decode the JSON string into an array
                $decoded = json_decode($cleanValue, true);

                // Return true if the requested disaster type exists in the decoded value
                return in_array($request->disasterType, $decoded);
            });

            // Log the filtered data for debugging
            \Log::info('Filtered Data:', ['data' => $filteredRequests]);

            $donationRequest = new \Illuminate\Pagination\LengthAwarePaginator(
                $filteredRequests->forPage($request->page ?? 1, 3),
                $filteredRequests->count(),
                3
            );

        } else {
            // If no specific disaster type is selected, apply the pagination normally
            $donationRequest = $query->paginate(3);
        }

        // Return the filtered data and view
        return response()->json([
            'view' => view('main.donation_request_filter', compact('donationRequest'))->render(),
            'pagination' => $donationRequest->links()->toHtml(),
        ]);
    }


}
