<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\Donation;
use App\Models\RequestDonation;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;

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
            $totalActiveDonation = Donation::where('status', '!=', 'Pending Approval')->where('status', '!=', 'Distributed')->where('barangay_id', $barangay->id)->count();
            $totalDonation = RequestDonation::where('status', 'Approved')->count();

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
                'totalActiveDonation' => $totalActiveDonation,
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
            $pendingDisasterReport = RequestDonation::where('status', 'Pending Approval')->count();
            $verifiedDisasterReport = RequestDonation::where('status', 'Approved')->count();

            $barangayRequests = DB::table('request_donations')
                ->select('barangay_id', DB::raw('COUNT(*) as request_count'))
                ->groupBy('barangay_id')
                ->get();

            $prioritization = DB::table('barangays')
                ->select('fire_risk_level', 'flood_risk_score')
                ->get();

            $totalDonations = DB::table('donations')
                ->select('barangay_id', DB::raw('SUM(donor_id) as total_donations'))
                ->groupBy('barangay_id')
                ->get();

                $userEngagement = DB::table('model_has_roles')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->join('users', 'model_has_roles.model_id', '=', 'users.id')
                ->select('roles.name as role', DB::raw('COUNT(users.id) as user_count'))
                ->where('roles.name', '!=', 'Content Manager')
                ->groupBy('roles.name')
                ->get();

            return view(
                'vendor.backpack.ui.dashboard',
                compact(
                    'pendingDisasterReport',
                    'verifiedDisasterReport',
                    'barangayRequests',
                    'prioritization',
                    'totalDonations',
                    'userEngagement'
                )
            );
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
            ->where('donations.status', 'Distributed') // Filter by status
            ->selectRaw('barangays.name as barangay_name, COUNT(*) as donation_count')
            ->groupBy('barangays.name')
            ->orderByDesc('donation_count')
            ->pluck('donation_count', 'barangay_name')
            ->toArray();

    }

    public function donationsChartData(Request $request)
    {
        $period = $request->get('period', 'daily');

        $query = DB::table('donations');

        if ($period === 'daily') {
            $query->selectRaw('DATE(donation_date) as period, COUNT(*) as total');
            $query->groupBy('period');
        } elseif ($period === 'weekly') {
            $query->selectRaw("YEAR(donation_date) as year, WEEK(donation_date, 1) as week, CONCAT(YEAR(donation_date), '-W', WEEK(donation_date, 1)) as period, COUNT(*) as total");
            $query->groupBy('year', 'week', 'period');
        } elseif ($period === 'monthly') {
            $query->selectRaw("DATE_FORMAT(donation_date, '%Y-%m') as period, COUNT(*) as total");
            $query->groupBy('period');
        }

        $results = $query->orderBy('period', 'ASC')->get();

        // Add week start and end dates for weekly period
        if ($period === 'weekly') {
            $results->transform(function ($row) {
                // Calculate week start and end dates
                [$year, $week] = explode('-W', $row->period);
                $startDate = new DateTime();
                $startDate->setISODate($year, $week); // Set to first day (Monday) of the week
                $endDate = clone $startDate;
                $endDate->add(new DateInterval('P6D')); // Add 6 days to get Sunday

                // Add start and end dates to the row
                $row->week_start = $startDate->format('Y-m-d');
                $row->week_end = $endDate->format('Y-m-d');

                return $row;
            });
        }

        return response()->json($results);
    }

    public function donationBreakdownChartData(Request $request)
    {
        $period = $request->get('period', 'daily');
        $query = DB::table('donation_items');

        // Filter by donation period (daily, weekly, or monthly)
        if ($period === 'daily') {
            $query->selectRaw('DATE(created_at) as period, JSON_UNQUOTE(donation_type) as category, COUNT(*) as total');
            $query->groupBy('period', 'category');
        } elseif ($period === 'weekly') {
            $query->selectRaw("YEAR(created_at) as year, WEEK(created_at) as week, CONCAT(YEAR(created_at), '-W', WEEK(created_at)) as period, JSON_UNQUOTE(donation_type) as category, COUNT(*) as total");
            $query->groupBy('year', 'week', 'category', 'period');
        } elseif ($period === 'monthly') {
            $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as period, JSON_UNQUOTE(donation_type) as category, COUNT(*) as total");
            $query->groupBy('period', 'category');
        }

        $results = $query->orderBy('period', 'ASC')->get();

        return response()->json($results);
    }

    public function getInventoryData()
    {
        $inventoryData = DB::table('inventory')
            ->select(DB::raw('donation_type, sum(quantity) as total'))
            ->groupBy('donation_type')
            ->get();

        return response()->json($inventoryData);
    }

}
