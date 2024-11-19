<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Article;
use App\Models\Terms;
use App\Models\User;
use Backpack\PageManager\app\Models\Page;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function landing()
    {
        // 'Received' => 'Received',
        //         'Under Segregation' => 'Under Segregation',
        //         'Categorized' => 'Categorized',
        //         'In Inventory' => 'In Inventory',
        //         'Ready for Distribution' => 'Ready for Distribution',
        //         'Distributed' => 'Distributed',
        //         'Completed' => 'Completed',
        $donationReceived = Donation::whereIn('status',['Received','Under Segregation','In Inventory', 'Ready for Distribution','Distributed','Completed'])->count();
        if ($donationReceived >= 1000000) {
            // Format the number to '1k' for values greater than or equal to 1000
            $donationReceived = number_format($donationReceived / 1000000, 1) . 'm';
        }elseif ($donationReceived >= 1000) {
            // Format the number to '1k' for values greater than or equal to 1000
            $donationReceived = number_format($donationReceived / 1000, 1) . 'k';
        }

        $registeredDonors = User::role('Normal User')->count();
        if ($registeredDonors >= 1000000) {
            // Format the number to '1k' for values greater than or equal to 1000
            $registeredDonors = number_format($registeredDonors / 1000000, 1) . 'm';
        }elseif ($registeredDonors >= 1000) {
            // Format the number to '1k' for values greater than or equal to 1000
            $registeredDonors = number_format($registeredDonors / 1000, 1) . 'k';
        }

        $donationGiven = Donation::whereIn('status',['Distributed','Completed'])->count();
        if ($donationGiven >= 1000000) {
            // Format the number to '1k' for values greater than or equal to 1000
            $donationGiven = number_format($donationGiven / 1000000, 1) . 'm';
        }elseif ($donationGiven >= 1000) {
            // Format the number to '1k' for values greater than or equal to 1000
            $donationGiven = number_format($donationGiven / 1000, 1) . 'k';
        }

        // $about = Page::where('template','about_us')->firstOrFail();
        $contact = Page::where('template','contact_us')->firstOrFail();
        
        $latestNews = Article::where('status', 'PUBLISHED')
        ->orderBy('date', 'desc')
        ->take(3)
        ->get();
        
        return view('home', compact('contact', 'registeredDonors', 'donationReceived', 'donationGiven', 'latestNews'));
    }

    public function terms()
    {
        $terms = Terms::firstOrFail();
        return view('main.terms', compact('terms'));
    }
}
