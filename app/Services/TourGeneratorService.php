<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TourGeneratorService
{
    /**
     * Generate a Google Earth VR tour file
     *
     * @param array $destinationFiles Array of uploaded JPG files
     * @param int $delay Time to stay at each destination (seconds)
     * @param int $initTime Starting hour of the day (0-23)
     * @param int $endTime Ending hour of the day (0-23)
     * @param string $tourName Name of the tour
     * @return string The generated tour file content
     * @throws \Exception If tour generation fails
     */
    public function generateTour(array $destinationFiles, int $delay, int $initTime, int $endTime, string $tourName): string
    {
        // Extract metadata from the uploaded JPG files
        $destinations = $this->extractMetadata($destinationFiles);
        
        if (empty($destinations)) {
            throw new \Exception('No location metadata found in the uploaded files');
        }
        
        // Get elevation data for all destinations
        $this->fetchElevationData($destinations);
        
        // Sort destinations by filename to maintain order
        ksort($destinations);
        
        // Generate the tour file
        return $this->buildTourFile($destinations, $delay, $initTime, $endTime, $tourName);
    }
    
    /**
     * Extract metadata from JPG files
     *
     * @param array $files Array of uploaded JPG files
     * @return array Extracted destination data
     */
    protected function extractMetadata(array $files): array
    {
        $destinations = [];
        
        foreach ($files as $file) {
            /** @var UploadedFile $file */
            $name = $file->getClientOriginalName();
            $content = file_get_contents($file->getRealPath(), false, null, 0, 4000);
            
            if (preg_match('/SerializedMetadata=\"(.+?)\"/', $content, $matches)) {
                $metadata = base64_decode($matches[1]);
                
                // Extract coordinates and scale from metadata
                $lat = unpack("d", substr($metadata, (strlen($metadata) - 92), 8));
                $long = unpack("d", substr($metadata, (strlen($metadata) - 83), 8));
                $scale = unpack("d", substr($metadata, (strlen($metadata) - 25), 8));
                
                $destinations[$name] = [
                    'lat' => $lat[1],
                    'long' => $long[1],
                    'scale' => $scale[1],
                    'name' => pathinfo($name, PATHINFO_FILENAME),
                ];
            }
        }
        
        return $destinations;
    }
    
    /**
     * Fetch elevation data for all destinations
     *
     * @param array &$destinations Destination data (passed by reference)
     * @throws \Exception If elevation data cannot be fetched
     */
    protected function fetchElevationData(array &$destinations): void
    {
        // Build location string for the API request
        $locationString = implode('|', array_map(function ($dest) {
            return $dest['lat'] . ',' . $dest['long'];
        }, $destinations));
        
        // Check if we have cached elevation data
        $cacheKey = 'elevation_data_' . md5($locationString);
        $elevationData = Cache::remember($cacheKey, now()->addDays(30), function () use ($locationString) {
            // Make API request to Google Maps Elevation API
            $response = Http::get('https://maps.googleapis.com/maps/api/elevation/json', [
                'locations' => $locationString,
                'key' => config('services.google.maps_api_key'),
            ]);
            
            if (!$response->successful() || $response->json('status') !== 'OK') {
                Log::error('Elevation API error', [
                    'status' => $response->json('status'),
                    'error_message' => $response->json('error_message'),
                ]);
                throw new \Exception('Unable to fetch elevation data: ' . ($response->json('error_message') ?? 'Unknown error'));
            }
            
            return $response->json('results');
        });
        
        // Apply elevation data to destinations
        foreach ($elevationData as $result) {
            foreach ($destinations as $name => $destination) {
                if (abs($destination['lat'] - $result['location']['lat']) < 0.00000000001 && 
                    abs($destination['long'] - $result['location']['lng']) < 0.00000000001) {
                    $destinations[$name]['elevation'] = $result['elevation'];
                }
            }
        }
    }
    
    /**
     * Build the tour file content
     *
     * @param array $destinations Destination data
     * @param int $delay Time to stay at each destination (seconds)
     * @param int $initTime Starting hour of the day (0-23)
     * @param int $endTime Ending hour of the day (0-23)
     * @param string $tourName Name of the tour
     * @return string The generated tour file content
     */
    protected function buildTourFile(array $destinations, int $delay, int $initTime, int $endTime, string $tourName): string
    {
        $output = "name: \"" . $tourName . "\"\r\n\r\n";
        $output .= "#Generated by Google Earth VR Custom Tour Generator\r\n";
        $output .= "#Include a file named 'bgaudio1.ogg' if you want a looping audio track\r\n";
        $output .= "audio_resource: {\r\n";
        $output .= "  name: \"BGAUDIO1\"\r\n";
        $output .= "  audio_path: \"bgaudio1.ogg\"\r\n";
        $output .= "  audio_type: DIRECT_STEREO\r\n";
        $output .= "}\r\n\r\n";
        $output .= "sound_keyframes: {\r\n";
        $output .= "  timestamp_seconds: 0\r\n";
        $output .= "  name: \"BGAUDIO1\"\r\n";
        $output .= "  sound_action: PLAY_LOOPING\r\n";
        $output .= "}\r\n\r\n";
        
        $index = 0;
        $total = count($destinations);
        
        foreach ($destinations as $name => $destination) {
            // Calculate time of day based on longitude
            $localInitTime = round(($initTime - (($destination['long']) / 180) * 12));
            $localEndTime = round(($endTime - (($destination['long']) / 180) * 12));
            
            // Handle day wrapping
            $initDay = ($localInitTime >= 24) ? 20 : 19;
            $localInitTime = ($localInitTime >= 24) ? $localInitTime - 24 : $localInitTime;
            
            $endDay = ($localEndTime >= 24) ? 20 : 19;
            $localEndTime = ($localEndTime >= 24) ? $localEndTime - 24 : $localEndTime;
            
            // Add destination to tour
            $output .= "# " . $name . "\r\n";
            $output .= "sound_keyframes: {\r\n";
            $output .= "  timestamp_seconds: " . ($index * $delay) . "\r\n";
            $output .= "  name: \"DSTAUDIO_" . $destination['name'] . "\"\r\n";
            $output .= "  sound_action: PLAY_LOOPING\r\n";
            $output .= "}\r\n\r\n";
            
            $output .= "view_keyframes: {\r\n";
            $output .= "  timestamp_seconds: " . ($index * $delay) . "\r\n";
            $output .= "  view: {\r\n";
            $output .= "    location: {\r\n";
            $output .= "      latitude: " . $destination['lat'] . "\r\n";
            $output .= "      longitude: " . $destination['long'] . "\r\n";
            $output .= "      altitude: " . $destination['elevation'] . "\r\n";
            $output .= "    }\r\n";
            $output .= "    anchor_point: {\r\n";
            $output .= "      x: 0\r\n";
            $output .= "      y: 0\r\n";
            $output .= "      z: 0\r\n";
            $output .= "    }\r\n";
            $output .= "    heading: 0\r\n";
            $output .= "    reference_space: ACTOR_FLOOR_SPACE\r\n";
            $output .= "    viewer_scale: " . $destination['scale'] . "\r\n";
            $output .= "    up_direction: SKY\r\n";
            $output .= "  }\r\n";
            $output .= "  name: \"" . str_replace('_', ' ', $destination['name']) . "\"\r\n";
            $output .= "  description: \"" . ($index + 1) . ' of ' . $total . "\"\r\n";
            $output .= "}\r\n\r\n";
            
            $output .= "audio_resource: {\r\n";
            $output .= "  name: \"DSTAUDIO_" . $destination['name'] . "\"\r\n";
            $output .= "  audio_path: \"" . $destination['name'] . ".ogg\"\r\n";
            $output .= "  audio_type: DIRECT_STEREO\r\n";
            $output .= "}\r\n\r\n";
            
            // Add time simulation
            $output .= "simulation_time_keyframes: {\r\n";
            $output .= "  timestamp_seconds: " . ($index * $delay) . "\r\n";
            $output .= "  simulation_time: {\r\n";
            $output .= "    year: 2025\r\n";  // Updated to current year
            $output .= "    month: 3\r\n";
            $output .= "    day: " . $initDay . "\r\n";
            $output .= "    hour: " . $localInitTime . "\r\n";
            $output .= "    minute: 0\r\n";
            $output .= "    second: 0\r\n";
            $output .= "  }\r\n";
            $output .= "  type: FIXED_PLANET\r\n";
            $output .= "}\r\n\r\n";
            
            $output .= "simulation_time_keyframes: {\r\n";
            $output .= "  timestamp_seconds: " . (($index + 1) * $delay) . "\r\n";
            $output .= "  simulation_time: {\r\n";
            $output .= "    year: 2025\r\n";  // Updated to current year
            $output .= "    month: 3\r\n";
            $output .= "    day: " . $endDay . "\r\n";
            $output .= "    hour: " . $localEndTime . "\r\n";
            $output .= "    minute: 0\r\n";
            $output .= "    second: 0\r\n";
            $output .= "  }\r\n";
            $output .= "  type: FIXED_PLANET\r\n";
            $output .= "}\r\n\r\n";
            
            // Add fade effects (except for first location)
            if ($index > 0) {
                $output .= "screen_fade_keyframes: {\r\n";
                $output .= "  timestamp_seconds: " . (($index * $delay) + 0.5) . "\r\n";
                $output .= "  opacity: 0.0\r\n";
                $output .= "}\r\n\r\n";
                
                $output .= "screen_fade_keyframes: {\r\n";
                $output .= "  timestamp_seconds: " . (($index * $delay) + 1.0) . "\r\n";
                $output .= "  opacity: 1.0\r\n";
                $output .= "}\r\n\r\n";
            }
            
            // Add fade out (except for last location)
            if ($index < ($total - 1)) {
                $output .= "screen_fade_keyframes: {\r\n";
                $output .= "  timestamp_seconds: " . ((($index + 1) * $delay) - 0.5) . "\r\n";
                $output .= "  opacity: 1.0\r\n";
                $output .= "}\r\n\r\n";
                
                $output .= "screen_fade_keyframes: {\r\n";
                $output .= "  timestamp_seconds: " . (($index + 1) * $delay) . "\r\n";
                $output .= "  opacity: 0.0\r\n";
                $output .= "}\r\n\r\n";
            }
            
            // Stop location-specific audio
            $output .= "sound_keyframes: {\r\n";
            $output .= "  timestamp_seconds: " . (($index + 1) * $delay) . "\r\n";
            $output .= "  name: \"DSTAUDIO_" . $destination['name'] . "\"\r\n";
            $output .= "  sound_action: STOP\r\n";
            $output .= "}\r\n\r\n";
            
            $index++;
        }
        
        // Stop background audio at the end
        $output .= "sound_keyframes: {\r\n";
        $output .= "  timestamp_seconds: " . ($index * $delay) . "\r\n";
        $output .= "  name: \"BGAUDIO1\"\r\n";
        $output .= "  sound_action: STOP\r\n";
        $output .= "}\r\n";
        
        return $output;
    }
}