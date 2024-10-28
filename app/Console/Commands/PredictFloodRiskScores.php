<?php

namespace App\Console\Commands;

use App\Models\Barangay;
use Illuminate\Console\Command;
use Phpml\ModelManager;

class PredictFloodRiskScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flood:predict-risk-scores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Predict and update flood risk scores for all barangays';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelPath = storage_path('app/models/flood_model.model'); // Ensure the correct path

        if (!file_exists($modelPath)) {
            $this->error('Model file not found. Please train the model first.');
            return;
        }

        // Load the trained model
        $modelManager = new ModelManager();
        $model = $modelManager->restoreFromFile($modelPath);

        $barangays = Barangay::all();
        foreach ($barangays as $barangay) {
            $frequency = $barangay->flood_frequency;
            $predictedScore = $model->predict([$frequency]);

            // Update the database with the predicted score
            $barangay->flood_risk_score = round($predictedScore, 1); // Save rounded score
            $barangay->save();

            $this->info("Barangay ID {$barangay->id} updated with risk score: {$predictedScore}");
        }

        $this->info('Flood risk scores updated successfully.');
    }
}
