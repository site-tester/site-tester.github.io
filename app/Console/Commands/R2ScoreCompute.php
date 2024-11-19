<?php

namespace App\Console\Commands;

use App\Models\Barangay;
use Illuminate\Console\Command;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\ModelManager;

class R2ScoreCompute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flood:r2s-compute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve flood frequency and corresponding risk scores
        $samples = [];
        $labels = [];

        $barangays = Barangay::all();

        $maxFrequency = $barangays->max('flood_frequency') ?: 1; // Prevent division by 0

        // Collect training data
        foreach ($barangays as $barangay) {
            $samples[] = [$barangay->flood_frequency]; // Use only flood frequency as feature
            $labels[] = $this->getDynamicRiskScore($barangay->flood_frequency, $maxFrequency);
        }

        // Train the model
        $model = new SVR(Kernel::LINEAR);
        $model->train($samples, $labels);

        if (!file_exists(storage_path('app/models'))) {
            mkdir(storage_path('app/models'), 0775, true);
        }

        // Save the model
        $modelPath = storage_path('app/models/flood_model.model');
        $modelManager = new ModelManager();
        $modelManager->saveToFile($model, $modelPath);

        $this->info('Flood risk model trained successfully!');

        // Load the trained model for predictions
        if (!file_exists($modelPath)) {
            $this->error('Model file not found. Please train the model first.');
            return;
        }

        // Load the trained model
        $model = $modelManager->restoreFromFile($modelPath);

        $predictions = [];
        $actuals = [];

        foreach ($barangays as $barangay) {
            $frequency = $barangay->flood_frequency;
            $predictedScore = $model->predict([$frequency]);

            // Update the database with the predicted score
            $barangay->flood_risk_score = round($predictedScore, 1); // Save rounded score
            $barangay->save();

            $this->info("Barangay ID {$barangay->id} updated with risk score: {$predictedScore}");

            // Collect predicted and actual values for R² calculation
            $predictions[] = $predictedScore;
            $actuals[] = $this->getDynamicRiskScore($barangay->flood_frequency, $maxFrequency);
        }

        // Calculate R² score
        $r2Score = $this->calculateR2Score($actuals, $predictions);

        $this->info("Actual risk scores: " . implode(", ", $labels));  // Print actual risk scores
        $this->info("Predicted risk scores: " . implode(", ", $predictions));  // Print predicted risk scores


        $this->info('Flood risk scores updated successfully.');
        $this->info("R² score: $r2Score");
    }

    private function getDynamicRiskScore($frequency, $maxFrequency)
    {
        // Scale frequency to a score out of 10
        return round(($frequency / $maxFrequency) * 10, 1);
    }

    private function calculateR2Score(array $actuals, array $predictions)
    {
        $meanActual = array_sum($actuals) / count($actuals); // Mean of actual values

        // Check if all actual values are the same (i.e., variance is 0)
        if (count(array_unique($actuals)) === 1) {
            // If all actual values are the same, return 1.0 (perfect score)
            return 1.0;
        }

        $ssTotal = 0;
        $ssResidual = 0;

        for ($i = 0; $i < count($actuals); $i++) {
            $ssTotal += pow($actuals[$i] - $meanActual, 2);
            $ssResidual += pow($actuals[$i] - $predictions[$i], 2);
        }

        return 1 - ($ssResidual / $ssTotal); // R² score
    }
}
