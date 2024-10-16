<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeAndDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run php artisan serve and npm run dev';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('Starting Laravel development server...');
        $serveProcess = popen('php artisan serve', 'r');

        if ($serveProcess) {
            $this->info('Laravel development server started.');

            // Run npm run dev in a separate process
            $this->info('Starting npm run dev...');
            $npmProcess = popen('npm run dev', 'r');

            if ($npmProcess) {
                $this->info('npm run dev started.');
            } else {
                $this->error('Failed to start npm run dev.');
            }
        } else {
            $this->error('Failed to start Laravel development server.');
        }

        // Keep the command running
        while (!feof($serveProcess) && !feof($npmProcess)) {
            echo fgets($serveProcess);
            echo fgets($npmProcess);
        }

        pclose($serveProcess);
        pclose($npmProcess);
    }
}
