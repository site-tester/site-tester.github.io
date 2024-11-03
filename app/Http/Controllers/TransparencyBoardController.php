<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransparencyBoardController extends Controller
{
    //
    public function getTransparencyData(Request $request)
    {
        $barangayId = $request->input('barangay_id');
        $timePeriod = $request->input('time_period');
        $year = $request->input('year') ?? now()->year;

        $query = Donation::where('donor_id', Auth::id())->with(['barangay', 'donor', 'donationItems']);

        // Apply barangay, year, and time filters as needed
        if ($barangayId) {
            $query->where('barangay_id', $barangayId);
        }
        $query->whereYear('donation_date', $year);

        if ($timePeriod && $timePeriod !== 'Annual') {
            $months = match ($timePeriod) {
                'Q1' => [1, 2, 3],
                'Q2' => [4, 5, 6],
                'Q3' => [7, 8, 9],
                'Q4' => [10, 11, 12],
            };
            $query->whereIn(\DB::raw('MONTH(donation_date)'), $months);
        }

        // Get donations and include donation items
        $donations = $query->get()->map(function ($donation) {
            return [
                'coordinator' => $donation->coordinator ?? '-',
                'anonymous' => $donation->anonymous,
                'donor_name' => $donation->donor->name,
                'donation_date' => $donation->donation_date,
                'donation_type' => $donation->type,
                'barangay_name' => $donation->barangay->name,
                'items' => $donation->donationItems->pluck('item_name')->toArray(),
                'quantities' => $donation->donationItems->pluck('quantity')->toArray(),
                'status' => $donation->status,
                'updated_at' => $donation->updated_at,
            ];
        });

        return response()->json(['donations' => $donations]);
    }


}
