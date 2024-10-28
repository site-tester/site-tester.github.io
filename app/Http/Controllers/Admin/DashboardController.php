<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\Donation;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Normal User'); // Replace 'Normal User' with the exact role name
        })->count();
        $pendingDonation = Donation::where('status', 'Pending Approval')->count();
        $barangay = Barangay::where('barangay_rep_id', Auth::user()->id)->firstOrFail();
        $totalDonation = Donation::where('barangay_id', $barangay->id)->count();

        $individualDonor = $this->individualDonor();
        $organizationDonor = $this->organizationDonor();
        $donorTypesCount = $this->getDonorTypesCount();
        $getDonationTypesCount = $this->getDonationTypesCount();
        $barangayDonations = $this->getDonationsByBarangay();

        return view('vendor.backpack.ui.dashboard', [
            'totalDonors' => $totalUsers,
            'pendingDonation' => $pendingDonation,
            'totalDonation' => $totalDonation,
            'individualDonor' => $individualDonor,
            'organizationDonor' => $organizationDonor,
            'donorTypesCount' => $donorTypesCount,
            'getDonationTypesCount' => $getDonationTypesCount,
            'barangayDonations' => $barangayDonations,
        ]);
    }

    private function individualDonor()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Get individual donations by checking if `other_details` is null in the joined user_profiles table
        $donations = Donation::whereBetween('donations.created_at', [$startOfWeek, $endOfWeek])
            ->join('users', 'donations.donor_id', '=', 'users.id')
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->whereNull('user_profiles.other_details')
            ->selectRaw('DAYOFWEEK(donations.created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return $this->formatDonationsByDay($donations);
    }

    private function organizationDonor()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Get organization donations by checking if `other_details` is not null in the joined user_profiles table
        $donations = Donation::whereBetween('donations.created_at', [$startOfWeek, $endOfWeek])
            ->join('users', 'donations.donor_id', '=', 'users.id')
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->whereNotNull('user_profiles.other_details')
            ->selectRaw('DAYOFWEEK(donations.created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return $this->formatDonationsByDay($donations);
    }

    // Helper method to format donations by day
    private function formatDonationsByDay($donations)
    {
        // Initialize data for each day (Sunday = 1 to Saturday = 7)
        return collect([1, 2, 3, 4, 5, 6, 7])->mapWithKeys(function ($day) use ($donations) {
            return [$day => $donations->firstWhere('day', $day)->count ?? 0];
        });
    }

    private function getDonorTypesCount()
    {
        // Count individual donors where `other_details` is null
        $individualCount = UserProfile::whereNull('other_details')->count();

        // Count organization donors where `other_details` is not null
        $organizationCount = UserProfile::whereNotNull('other_details')->count();

        return [
            'individual' => $individualCount,
            'organization' => $organizationCount,
        ];
    }

    private function getDonationTypesCount()
    {
        // Count individual donors where `other_details` is null
        $FoodDonationCount = Donation::where('type', 'Food')->count();

        // Count organization donors where `other_details` is not null
        $NonFoodDonationCount = Donation::where('type', 'NonFood')->count();

        $MedicalDonationCount = Donation::where('type', 'Medical')->count();

        return [
            'FoodDonationCount' => $FoodDonationCount,
            'NonFoodDonationCount' => $NonFoodDonationCount,
            'MedicalDonationCount' => $MedicalDonationCount,
        ];
    }

    private function getDonationsByBarangay()
    {
        return Donation::join('barangays', 'donations.barangay_id', '=', 'barangays.id')
            ->selectRaw('barangays.name as barangay_name, COUNT(*) as donation_count')
            ->groupBy('barangays.name')
            ->orderByDesc('donation_count')
            ->pluck('donation_count', 'barangay_name')
            ->toArray();
    }
}
