<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Auth;

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

    public function viewProfile(){
        $profile = UserProfile::where( 'user_id', '=', Auth::user()->id)->firstOrFail();
        // dd($profile);
        return view('main.profile',compact('profile'));
    }

    public function viewDonateNow(Request $request){
        $donation_type = $request->donation_type;
        $barangayID = $request->barangay;
        $barangayLists = Barangay::orderBy('name')->get();
        return view('main.donationForm', compact('barangayLists', 'donation_type', 'barangayID'));
    }

}
