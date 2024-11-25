<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Metric\Regression;
use Phpml\ModelManager;

class FloodPredictController extends Controller
{
    //
    public function trainModel()
    {
        // Prepare the dataset
        $samples = Barangay::all()->map(function ($barangay) {
            // Calculate the average flood severity for this barangay
            $averageSeverity = DB::table('floods')
                ->where('barangay_id', $barangay->id)
                ->avg('severity_score');  // Adjust 'severity' to the exact column name in the 'floods' table

            return [
                $barangay->flood_frequency,
                $averageSeverity ?? 0, // Use 0 if there are no flood records for a barangay
                // Add other features as needed
            ];
        })->toArray();


        // Define labels based on vulnerability or risk level (e.g., high, medium, low)
        $labels = Barangay::all()->map(function ($barangay) {
            return $this->calculateRiskLevel($barangay->flood_frequency);
        })->toArray();

        // Train the model
        $classifier = new KNearestNeighbors();
        $classifier->train($samples, $labels);

        // Example prediction for a specific barangay
        // $testData = [5]; // Replace with actual feature values for a new barangay
        // $prediction = $classifier->predict($testData);
        // Storage::put('models/flood_classifier.model', serialize($classifier));
        $modelManager = new ModelManager();
        $modelManager->saveToFile($classifier, 'model/flood_model.model');

        // return response()->json([
        //     'prediction' => $prediction,
        // ]);
    }

    public function trainAndPredict()// $data
    {
        // Prepare the dataset
        $samples = Barangay::all()->map(function ($barangay) {
            // Calculate the average flood severity for this barangay
            $averageSeverity = DB::table('floods')
                ->where('barangay_id', $barangay->id)
                ->avg('severity_score');  //  column name in the 'floods' table

            return [
                $barangay->flood_frequency,
                $averageSeverity ?? 0, // Use 0 if there are no flood records for a barangay
                // Add other features as needed
            ];
        })->toArray();

        // Define labels based on vulnerability or risk level (e.g., high, medium, low)
        $labels = Barangay::all()->map(function ($barangay) {
            return $this->calculateRiskLevel($barangay->flood_frequency);
        })->toArray();

        // Train the model
        $model = new KNearestNeighbors();
        $model->train($samples, $labels);


        // // Train the model
        $classifier = new KNearestNeighbors();
        $classifier->train($samples, $labels);

        // Example prediction for a specific barangay
        $testData = [5,1]; // Replace with actual feature values for a new barangay

        $prediction = $classifier->predict($testData);
        // Storage::put('models/flood_classifier.model', serialize($classifier));

        return response()->json([
            'prediction' => $prediction,
        ]);
    }

    // Calculate risk level based on flood frequency for labeling purposes
    private function calculateRiskLevel($frequency)
    {
        if ($frequency > 10) {
            return 'high';
        } elseif ($frequency > 5) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    public function updateFloodFrequency()
{
    // Get flood counts grouped by barangay_id
    $floodCounts = DB::table('floods')
        ->select('barangay_id', DB::raw('count(*) as flood_count'))
        ->groupBy('barangay_id')
        ->get();

    // Update each barangay's flood_frequency with the count from floods table
    foreach ($floodCounts as $floodCount) {
        Barangay::where('id', $floodCount->barangay_id)
            ->update(['flood_frequency' => $floodCount->flood_count]);
    }

    // Optionally, set flood_frequency to 0 for barangays with no flood records
    Barangay::whereNotIn('id', $floodCounts->pluck('barangay_id'))
        ->update(['flood_frequency' => 0]);

    return response()->json(['status' => 'Flood frequencies updated successfully.']);
}
}
