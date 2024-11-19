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

            $predictions[] = $predictedScore;
            $actuals[] = $barangay->flood_risk_score;
            $this->info("Barangay ID {$barangay->id} updated with risk score: {$predictedScore}");
        }

        $r2 = $this->calculateR2Score($actuals, $predictions);
        $mae = $this->calculateMAE($actuals, $predictions);
        $mse = $this->calculateMSE($actuals, $predictions);

        $this->info("R² score: $r2");
        $this->info("Mean Absolute Error (MAE): $mae");
        $this->info("Mean Squared Error (MSE): $mse");
        
        $this->info('Flood risk scores updated successfully.');
    }
    
    private function calculateR2Score(array $actuals, array $predictions): float
    {
        $meanActual = array_sum($actuals) / count($actuals);
        $ssTotal = 0;
        $ssResidual = 0;

        foreach ($actuals as $i => $actual) {
            $ssTotal += pow($actual - $meanActual, 2);
            $ssResidual += pow($actual - $predictions[$i], 2);
        }

        return 1 - ($ssResidual / $ssTotal); // R² score
    }
    // Helper function to calculate MAE
    private function calculateMAE($actuals, $predictions)
    {
        $sumAbsoluteError = 0;
        $n = count($actuals);

        for ($i = 0; $i < $n; $i++) {
            $sumAbsoluteError += abs($actuals[$i] - $predictions[$i]);
        }

        return $sumAbsoluteError / $n;
    }

    // Helper function to calculate MSE
    private function calculateMSE($actuals, $predictions)
    {
        $sumSquaredError = 0;
        $n = count($actuals);

        for ($i = 0; $i < $n; $i++) {
            $sumSquaredError += pow($actuals[$i] - $predictions[$i], 2);
        }

        return $sumSquaredError / $n;
    }
}
