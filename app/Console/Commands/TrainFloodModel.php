<?php

namespace App\Console\Commands;

use App\Models\Barangay;
use Illuminate\Console\Command;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Regression\LinearRegression;
use Phpml\ModelManager;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;

class TrainFloodModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flood:train-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Train the flood risk prediction model';

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

        foreach ($barangays as $barangay) {
            $samples[] = [$barangay->flood_frequency]; // Use only flood frequency as feature
            $labels[] = $this->getDynamicRiskScore($barangay->flood_frequency, $maxFrequency);
        }
        // dd($samples, $labels);
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
    }

    private function getDynamicRiskScore($frequency, $maxFrequency)
    {
        // Scale frequency to a score out of 10
        return round(($frequency / $maxFrequency) * 10, 1);
    }
}
