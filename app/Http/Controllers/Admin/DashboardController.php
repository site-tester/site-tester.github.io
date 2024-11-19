<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\Donation;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        if (Auth::user()->hasRole('Barangay Representative')) {


            $totalUsers = User::whereHas('roles', function ($query) {
                $query->where('name', 'Normal User'); // Replace 'Normal User' with the exact role name
            })->count();
            $barangay = Barangay::where('barangay_rep_id', Auth::user()->id)->firstOrFail();
            $pendingDonation = Donation::where('status', 'Pending Approval')->where('barangay_id', $barangay->id)->count();
            $totalDonation = Donation::where('barangay_id', $barangay->id)->count();

            $individualDonor = $this->individualDonor();
            $organizationDonor = $this->organizationDonor();
            $donorTypesCount = $this->getDonorTypesCount();
            $getDonationTypesCount = $this->getDonationTypesCount();
            $barangayDonations = $this->getDonationsByBarangay();

            // Fetch donation summary grouped by barangay
            $donationSummary = Donation::select(
                'barangay_id',
                \DB::raw('COUNT(id) as total_donations'),
                \DB::raw("SUM(CASE WHEN status = 'Pending Approval' THEN 1 ELSE 0 END) as pending"),
                \DB::raw("SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved"),
                \DB::raw("SUM(CASE WHEN status = 'Received' THEN 1 ELSE 0 END) as received"),
                \DB::raw("SUM(CASE WHEN status = 'Distributed' THEN 1 ELSE 0 END) as distributed"),
                // \DB::raw("SUM(value) as total_value") // Assuming `value` field exists for donation value
            )
                ->with('barangay') // assuming the Donation model has a 'barangay' relationship
                ->groupBy('barangay_id')
                ->get();

            // Count donations by type (Food, NonFood, Medical) for each barangay
            $donationTypes = Donation::select(
                'barangay_id',
                \DB::raw("SUM(CASE WHEN type = 'Food' THEN 1 ELSE 0 END) as food_donations"),
                \DB::raw("SUM(CASE WHEN type = 'NonFood' THEN 1 ELSE 0 END) as non_food_donations"),
                \DB::raw("SUM(CASE WHEN type = 'Medical' THEN 1 ELSE 0 END) as medical_donations")
            )
                ->groupBy('barangay_id')
                ->get()
                ->keyBy('barangay_id');

            // Combine results into a summary for each barangay
            $barangaySummaries = $donationSummary->map(function ($donation) use ($donationTypes) {
                $barangayId = $donation->barangay_id;
                return [
                    'barangay' => $donation->barangay->name,
                    'total_donations' => $donation->total_donations,
                    'food_donations' => $donationTypes[$barangayId]->food_donations ?? 0,
                    'non_food_donations' => $donationTypes[$barangayId]->non_food_donations ?? 0,
                    'medical_donations' => $donationTypes[$barangayId]->medical_donations ?? 0,
                    'pending' => $donation->pending,
                    'approved' => $donation->approved,
                    'received' => $donation->received,
                    'distributed' => $donation->distributed,
                    'total_value' => $donation->total_value,
                ];
            });

            $donorSummaries = Donation::select(
                'users.name as donor_name',        // `users` table to get the donor's name
                'donations.type',
                'donations.status',
                DB::raw('COUNT(donations.id) as donation_count') // Removed total_amount as requested
            )
                ->join('users', 'users.id', '=', 'donations.donor_id')         // Correct table and join for `users`
                ->groupBy('users.name', 'donations.type', 'donations.status')
                ->orderBy('users.name')
                ->get();

            $donationTypeSummaries = Donation::select(
                'type',                               // Select donation type
                DB::raw('COUNT(id) as donation_count'),        // Count total donations per type
                DB::raw("SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_count"),    // Count of pending donations
                DB::raw("SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved_count"),  // Count of approved donations
                DB::raw("SUM(CASE WHEN status = 'Received' THEN 1 ELSE 0 END) as received_count"),  // Count of received donations
                DB::raw("SUM(CASE WHEN status = 'Distributed' THEN 1 ELSE 0 END) as distributed_count") // Count of distributed donations
            )
                ->groupBy('type')                         // Group by donation type
                ->orderBy('type')                         // Order by type for readability
                ->get();

            $years = DB::table('donations')
                ->select(DB::raw('YEAR(donation_date) as year'))
                ->distinct()
                ->orderBy('year', 'desc')
                ->get();

            return view('vendor.backpack.ui.dashboard', [
                'totalDonors' => $totalUsers,
                'pendingDonation' => $pendingDonation,
                'totalDonation' => $totalDonation,
                'individualDonor' => $individualDonor,
                'organizationDonor' => $organizationDonor,
                'donorTypesCount' => $donorTypesCount,
                'getDonationTypesCount' => $getDonationTypesCount,
                'barangayDonations' => $barangayDonations,
                'barangaySummaries' => $barangaySummaries,
                'donorSummaries' => $donorSummaries,
                'donationTypeSummaries' => $donationTypeSummaries,
                'years' => $years,
            ]);

        }

        if (Auth::user()->hasRole('Municipal Admin')) {
            return view('vendor.backpack.ui.dashboard', [

            ]);
        }
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
