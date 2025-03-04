<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('temp:cleanup', function () {
    $this->info('Cleaning up temporary files...');
    
    // Define the temporary storage path
    $tempPath = storage_path('app/temp');
    
    // Check if the directory exists
    if (!File::exists($tempPath)) {
        $this->info('Temporary directory does not exist. Creating it...');
        File::makeDirectory($tempPath, 0755, true);
        return;
    }
    
    // Get all files older than 24 hours
    $files = File::files($tempPath);
    $count = 0;
    
    foreach ($files as $file) {
        // Check if file is older than 24 hours
        if (time() - File::lastModified($file) > 86400) {
            File::delete($file);
            $count++;
        }
    }
    
    $this->info("Cleaned up {$count} temporary files.");
    Log::info("Temp cleanup: Removed {$count} files from {$tempPath}");
})->purpose('Clean up temporary files older than 24 hours');