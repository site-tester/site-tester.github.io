<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    //
    public function generateReport(Request $request)
    {
        $reportView = $request->input('reportView'); // This will contain "This Day", "This Week", etc.
        $monthName = $request->input('month');
        $year = $request->input('year');
        $reportData = [];
        // Logic for filtering donations based on report type
        // Construct the query based on the selected report view

        $month = null;
        if ($monthName) {
            $month = Carbon::parse($monthName)->month; // Get the month number (e.g., January -> 1, February -> 2)
        }

        $barangayId = Barangay::where('barangay_rep_id', Auth::user()->id)->first();
        $query = Donation::with(['donor', 'donationItems'])->where('barangay_id', $barangayId->id); // Assuming you have relationships in the models

        switch ($reportView) {
            case 'This Day':
                $query->whereDate('donation_date', Carbon::today('UTC'));
                break;
            case 'This Week':
                $query->whereBetween('donation_date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ]);
                break;
            case 'Month':
                if ($month) {
                    $query->whereMonth('donation_date', $month);
                }
                break;
            case 'Year':
                if ($year) {
                    $query->whereYear('donation_date', $year);
                }
                break;
            default:
                // If no filter is selected, you can load all donations or any other logic you want
                $query->latest();
                break;
        }

        $donations = $query->get();

        // Format the data into an array to return to the view
        foreach ($donations as $donation) {
            $reportData[] = [
                'id' => $donation->id,
                'coordinator' => $donation->coordinator ?? '-', // Use default if null
                'donor' => $donation->donor ? $donation->donor->name : '-', // Assuming you have a donor relation in your Donation model
                'type' => $donation->type, // Assuming you have a 'type' field in the Donation model
                'items' => $donation->donationItems->pluck('item_name')->implode(', '), // Assuming a donationItems relation with item_name
                'quantities' => $donation->donationItems->pluck('quantity')->implode(', '), // Assuming quantity field in donationItems
                'donation_date' => $donation->donation_date->format('Y-m-d'), // Format donation date
                'status' => $donation->status, // Assuming status is a field in the Donation model
            ];
        }

        return response()->json($reportData);
    }
}
