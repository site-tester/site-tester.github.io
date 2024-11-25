<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\DisasterRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function viewProfile()
    {
        $profile = UserProfile::where('user_id', '=', Auth::user()->id)->firstOrFail();
        // dd($profile);
        return view('main.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        // Fetch the user profile
        $userProfile = UserProfile::where('user_id', Auth::id())->firstOrFail();
        $user = User::where('id', Auth::id())->firstOrFail();
        // dd($user , $userProfile);
        // Validate input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'profileEmail' => 'required|email',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'profileOldPassword' => 'nullable|required_with:profilePassword',
            'profilePassword' => 'nullable|min:8|confirmed'
        ]);

        // Update profile fields
        $user->name = $request->name;
        $user->email = $request->profileEmail;
        $userProfile->contact_number = $request->contact_number;
        $userProfile->address = $request->address;

        // Update additional fields if they exist
        if ($request->has('organization')) {
            $userProfile->other_details = $request->organization;
        }

        // If password fields are provided and valid, hash and update the password
        if ($request->filled('profilePassword')) {
            $user->password = Hash::make($request->profilePassword);
        }

        // Save updated user details
        $userProfile->save();
        $user->save();

        // Redirect back with a success message
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function viewDonateNow(Request $request)
    {
        $donation_type = $request->donation_type;
        $barangayID = $request->barangay;
        $barangayLists = Barangay::orderBy('name')->get();
        return view('main.donationForm', compact('barangayLists', 'donation_type', 'barangayID'));
    }

    public function viewDonateUrgent($id)
    {
        $donationRequest = DisasterRequest::where('id', $id)->first();
        $barangayID = $donationRequest->barangay->id;
        $barangayLists = Barangay::orderBy('name')->get();
        return view('main.donationFormUrgent', compact('donationRequest', 'barangayLists', 'barangayID'));
    }

    

}
