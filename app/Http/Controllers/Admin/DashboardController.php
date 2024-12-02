<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\Donation;
use App\Models\Item;
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

            $barangay = Barangay::where('barangay_rep_id', Auth::user()->id)->firstOrFail();

            // Dashboard Cards
            $pendingDonation = Donation::where('status', 'Pending Approval')->where('barangay_id', $barangay->id)->count();
            $totalActiveDonation = Donation::where('status', '!=', 'Pending Approval')->where('status', '!=', 'Distributed')->where('barangay_id', $barangay->id)->count();
            $totalActiveDisasterReport = RequestDonation::where('status', 'Approved')->count();

            // $individualDonor = $this->individualDonor();
            // $organizationDonor = $this->organizationDonor();
            // $donorTypesCount = $this->getDonorTypesCount();
            // $getDonationTypesCount = $this->getDonationTypesCount();
            // $barangayDonations = $this->getDonationsByBarangay();

            // Fetch donation summary grouped by barangay
            // $donationSummary = Donation::select(
            //     'barangay_id',
            //     \DB::raw('COUNT(id) as total_donations'),
            //     \DB::raw("SUM(CASE WHEN status = 'Pending Approval' THEN 1 ELSE 0 END) as pending"),
            //     \DB::raw("SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved"),
            //     \DB::raw("SUM(CASE WHEN status = 'Received' THEN 1 ELSE 0 END) as received"),
            //     \DB::raw("SUM(CASE WHEN status = 'Distributed' THEN 1 ELSE 0 END) as distributed"),
            //     // \DB::raw("SUM(value) as total_value") // Assuming `value` field exists for donation value
            // )
            //     ->with('barangay') // assuming the Donation model has a 'barangay' relationship
            //     ->groupBy('barangay_id')
            //     ->get();

            // // Count donations by type (Food, NonFood, Medical) for each barangay
            // $donationTypes = Donation::select(
            //     'barangay_id',
            //     \DB::raw("SUM(CASE WHEN type = 'Food' THEN 1 ELSE 0 END) as food_donations"),
            //     \DB::raw("SUM(CASE WHEN type = 'NonFood' THEN 1 ELSE 0 END) as non_food_donations"),
            //     \DB::raw("SUM(CASE WHEN type = 'Medical' THEN 1 ELSE 0 END) as medical_donations")
            // )
            //     ->groupBy('barangay_id')
            //     ->get()
            //     ->keyBy('barangay_id');

            // Combine results into a summary for each barangay
            // $barangaySummaries = $donationSummary->map(function ($donation) use ($donationTypes) {
            //     $barangayId = $donation->barangay_id;
            //     return [
            //         'barangay' => $donation->barangay->name,
            //         'total_donations' => $donation->total_donations,
            //         'food_donations' => $donationTypes[$barangayId]->food_donations ?? 0,
            //         'non_food_donations' => $donationTypes[$barangayId]->non_food_donations ?? 0,
            //         'medical_donations' => $donationTypes[$barangayId]->medical_donations ?? 0,
            //         'pending' => $donation->pending,
            //         'approved' => $donation->approved,
            //         'received' => $donation->received,
            //         'distributed' => $donation->distributed,
            //         'total_value' => $donation->total_value,
            //     ];
            // });

            // $donorSummaries = Donation::select(
            //     'users.name as donor_name',
            //     'donations.type',
            //     'donations.status',
            //     DB::raw('COUNT(donations.id) as donation_count')
            // )
            //     ->join('users', 'users.id', '=', 'donations.donor_id')
            //     ->groupBy('users.name', 'donations.type', 'donations.status')
            //     ->orderBy('users.name')
            //     ->get();

            // $donationTypeSummaries = Donation::select(
            //     'type',                               // Select donation type
            //     DB::raw('COUNT(id) as donation_count'),        // Count total donations per type
            //     DB::raw("SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_count"),    // Count of pending donations
            //     DB::raw("SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved_count"),  // Count of approved donations
            //     DB::raw("SUM(CASE WHEN status = 'Received' THEN 1 ELSE 0 END) as received_count"),  // Count of received donations
            //     DB::raw("SUM(CASE WHEN status = 'Distributed' THEN 1 ELSE 0 END) as distributed_count") // Count of distributed donations
            // )
            //     ->groupBy('type')                         // Group by donation type
            //     ->orderBy('type')                         // Order by type for readability
            //     ->get();


            return view('vendor.backpack.ui.dashboard', [
                // Barangay Dashboard Card Returns
                'pendingDonation' => $pendingDonation,
                'totalActiveDonation' => $totalActiveDonation,
                'totalActiveDisasterReport' => $totalActiveDisasterReport,

                // 'individualDonor' => $individualDonor,
                // 'organizationDonor' => $organizationDonor,
                // 'donorTypesCount' => $donorTypesCount,
                // 'getDonationTypesCount' => $getDonationTypesCount,
                // 'barangayDonations' => $barangayDonations,
                // 'barangaySummaries' => $barangaySummaries,
                // 'donorSummaries' => $donorSummaries,
                // 'donationTypeSummaries' => $donationTypeSummaries,

            ]);

        }

        if (Auth::user()->hasRole('Municipal Admin')) {
            $pendingDisasterReport = RequestDonation::where('status', 'Pending Approval')->count();
            $verifiedDisasterReport = RequestDonation::where('status', 'Approved')->count();

            return view(
                'vendor.backpack.ui.dashboard',
                compact(
                    'pendingDisasterReport',
                    'verifiedDisasterReport',
                )
            );
        }
    }

    // Barangay Charts (Barangay Representative)



    // Admin Charts (Municipal Admin)
    // Chart 1
    public function getBarangayRequestsData()
    {
        $data = RequestDonation::with('barangay')
            ->select('barangay_id', DB::raw('COUNT(*) as total_requests'))
            ->groupBy('barangay_id')
            ->orderBy('total_requests', 'desc')
            ->get();

        return response()->json($data);
    }
    // Chart 2
    public function getVulnerabilityPrioritizationData()
    {
        // Get the start of the current week (Monday)
        $startOfWeek = now()->startOfWeek()->toDateString();

        // Get the end of the current week (Sunday)
        $endOfWeek = now()->endOfWeek()->toDateString();

        // Fetch data for the current week based on created_at
        $barangayData = RequestDonation::with('barangay')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek]) // Filter for this week's data
            ->get(); // Get all donations with associated barangay

        // Prepare the response data for chart
        $responseData = [];

        // Process each barangay and their vulnerability
        foreach ($barangayData as $request) {
            // Get the barangay name and vulnerability
            $barangayName = $request->barangay->name;
            $vulnerability = $request->vulnerability;

            // Add data to the response array based on vulnerability level
            $responseData[] = [
                'barangay' => $barangayName,
                'vulnerability' => $vulnerability
            ];
        }

        return response()->json($responseData);
    }
    // Chart 3
    public function getTotalDonationsPerBarangay()
    {
        // Fetch the total donations per barangay, and eager load the barangay relationship
        // $donationsData = Donation::with('barangay')  // Ensure barangay relationship is loaded
        //     ->select('barangay_id', DB::raw('count(*) as total_donations'))
        //     ->groupBy('barangay_id')
        //     ->get();
        $donationsData = Barangay::leftJoin('donations', 'barangays.id', '=', 'donations.barangay_id')
            ->where('donations.status', '!=', 'Pending Approval')
            ->select(
                'barangays.name as barangay_name',
                DB::raw('COUNT(donations.id) as total_donations')
            )
            ->groupBy('barangays.id', 'barangays.name')
            ->orderBy('barangays.name') // Optional: Sort the data alphabetically
            ->get();
        \Log::info($donationsData);
        // Prepare the response data for the chart
        $responseData = [];

        // Process the data to match the chart requirements

        foreach ($donationsData as $data) {
            $responseData[] = [
                'barangay' => $data->barangay_name,
                'total_donations' => $data->total_donations
            ];
        }

        return response()->json($responseData);
    }

    public function getUserRoleCounts()
    {
        // Define the roles to include
        $roles = ['Normal User' => 'Users', 'Barangay Representative' => 'Barangay', 'Municipal Admin' => 'Admin'];

        // Fetch counts for each role
        $roleCounts = [];
        foreach ($roles as $originalRole => $label) {
            $roleCounts[] = User::role($originalRole)->count();
        }

        // Prepare the response
        $data = [
            'roles' => array_values($roles),
            'counts' => $roleCounts
        ];

        return response()->json($data);
    }

    // ADMIN DASHBOARD CHARTS

    public function totalDonationsChartData(Request $request)
    {
        $filter = $request->input('filter', 'day'); // Default filter: daily

        $dateQuery = match ($filter) {
            'day' => Carbon::now()->startOfDay(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfDay()
        };

        $barangayUser = Barangay::where('barangay_rep_id', auth()->id())->first();
        $donations = Donation::where('barangay_id', $barangayUser->id)
            // ->whereNotNull('received_by')
            ->where('created_at', '>=', $dateQuery)
            ->get();

        return response()->json([
            'data' => $donations->groupBy(function ($donation) use ($filter) {
                return match ($filter) {
                    'daily' => $donation->created_at->format('H:i'), // By hour
                    'weekly', 'monthly' => $donation->created_at->format('d M'), // By day
                    'yearly' => $donation->created_at->format('M Y'), // By month
                    default => $donation->created_at->format('d M'),
                };
            })->map(fn($group) => $group->count()),
        ]);
    }
    public function donationCategoryChartData(Request $request)
    {
        $filter = $request->input('filter', 'day'); // Default filter: daily

        $dateQuery = match ($filter) {
            'day' => Carbon::now()->startOfDay(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfDay()
        };

        $barangayUser = Barangay::where('barangay_rep_id', auth()->id())->first();
        $donations = Donation::where('barangay_id', $barangayUser->id)
            ->where('created_at', '>=', $dateQuery)
            ->get();

        $categories = ['Food', 'NonFood', 'Medicine'];
        $groupedData = [];

        foreach ($categories as $category) {
            $groupedData[$category] = $donations->filter(function ($donation) use ($category) {
                return in_array($category, json_decode($donation->type) ?? '{}');
            })->groupBy(function ($donation) use ($filter) {
                return match ($filter) {
                    'daily' => $donation->created_at->format('H:i'), // By hour
                    'weekly', 'monthly' => $donation->created_at->format('d M'), // By day
                    'yearly' => $donation->created_at->format('M Y'), // By month
                    default => $donation->created_at->format('d M'),
                };
            })->map(fn($group) => $group->count());
        }

        return response()->json(['data' => $groupedData]);
    }
    public function inventoryStockChartData(Request $request)
    {
        $filter = $request->input('filter', 'day'); // Default filter: daily

        // Define the thresholds for Low, Mid, and High levels
        $lowThreshold = 10;   // Low if quantity < 10
        $midThreshold = 50;   // Mid if quantity >= 10 and <= 50
        $highThreshold = 51;  // High if quantity > 50

        // Determine the date range based on the filter
        $dateQuery = match ($filter) {
            'day' => Carbon::now()->startOfDay(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfDay(),
        };

        $barangayUser = Barangay::where('barangay_rep_id', auth()->id())->first();
        $inventoryItems = Item::where('barangay_id', $barangayUser->id)->where('created_at', '>=', $dateQuery)
            ->orWhere('updated_at', '>=', $dateQuery)
            ->get();


        $categorizedData = $inventoryItems->groupBy('donation_type')->map(function ($items) use ($lowThreshold, $midThreshold, $highThreshold) {
            // Initialize counters for each level
            $lowCount = 0;
            $midCount = 0;
            $highCount = 0;

            // Count items based on their quantity level
            foreach ($items as $item) {
                if ($item->quantity < $lowThreshold) {
                    $lowCount++;
                } elseif ($item->quantity >= $lowThreshold && $item->quantity <= $midThreshold) {
                    $midCount++;
                } else {
                    $highCount++;
                }
            }

            return [
                'low' => $lowCount,
                'mid' => $midCount,
                'high' => $highCount,
            ];
        });

        // Return the data in the format needed for the chart
        return response()->json([
            'data' => $categorizedData,
        ]);
    }
    public function distributedDonationChartData(Request $request)
    {
        $filter = $request->input('filter', 'day'); // Default filter: daily

        try {
            // Determine the date range based on the filter
            $dateQuery = match ($filter) {
                'day' => Carbon::now()->startOfDay(),
                'week' => Carbon::now()->startOfWeek(),
                'month' => Carbon::now()->startOfMonth(),
                'year' => Carbon::now()->startOfYear(),
                default => Carbon::now()->startOfDay(),
            };

            $barangayUser = Barangay::where('barangay_rep_id', auth()->id())->first();
            // Fetch distributed donations within the specified date range
            $donations = Donation::where('barangay_id', $barangayUser->id)
                ->whereNotNull('distributed_by') // Ensure that the donation has been distributed
                ->where('updated_at', '>=', $dateQuery)
                ->get();

            $groupedData = $donations->groupBy(function ($distribution) use ($filter) {
                return match ($filter) {
                    'day' => $distribution->updated_at->format('d M'),
                    'week' => $distribution->updated_at->format('W'),
                    'month' => $distribution->updated_at->format('M Y'),
                    'year' => $distribution->updated_at->format('Y'),
                    default => $distribution->updated_at->format('d M'),
                };
            })->map(fn($group) => $group->count());

            // Return the data in the format needed for the chart
            // return response()->json([
            //     'data' => $donations->groupBy(function ($donation) use ($filter) {
            //         return match ($filter) {
            //             'day' => $donation->distributed_at->format('d M'), // Group by day
            //             'week' => $donation->distributed_at->format('W'), // Group by week of the year
            //             'month' => $donation->distributed_at->format('M Y'), // Group by month
            //             'year' => $donation->distributed_at->format('Y'), // Group by year
            //             default => $donation->distributed_at->format('d M'),
            //         };
            //     })->map(fn($group) => $group->count()),
            // ]);

            return response()->json([
                'data' => $groupedData->toArray(), // Ensure this is an array, even if empty
            ]);
        } catch (\Exception $e) {
            // Handle exception and return error message
            return response()->json(['error' => 'Failed to fetch data', 'message' => $e->getMessage()], 500);
        }
    }

}
