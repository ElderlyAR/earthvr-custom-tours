<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TourGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TourApiController extends Controller
{
    protected $tourGenerator;

    public function __construct(TourGeneratorService $tourGenerator)
    {
        $this->tourGenerator = $tourGenerator;
    }

    /**
     * Generate a tour file from uploaded JPG files
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'destinations' => 'required|array',
            'destinations.*' => 'required|file|mimes:jpg,jpeg|max:' . (config('tour.max_upload_size', 64) * 1024),
            'delay' => 'required|numeric|min:1|max:300',
            'init_time' => 'required|numeric|min:0|max:23',
            'end_time' => 'required|numeric|min:0|max:23',
            'tourname' => 'required|string|max:255|regex:/^[a-zA-Z0-9_\s-]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'The provided data was invalid.',
                'details' => $validator->errors(),
            ], 400);
        }

        try {
            // Generate the tour file
            $tourContent = $this->tourGenerator->generateTour(
                $request->file('destinations'),
                $request->input('delay'),
                $request->input('init_time'),
                $request->input('end_time'),
                $request->input('tourname')
            );

            // Return the tour file as a download
            return response($tourContent)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename=earthVR.textpb')
                ->header('Content-Length', strlen($tourContent));
        } catch (\Exception $e) {
            Log::error('API tour generation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validate JPG files to ensure they contain the required metadata
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function validate(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'files' => 'required|array',
            'files.*' => 'required|file|mimes:jpg,jpeg|max:' . (config('tour.max_upload_size', 64) * 1024),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'The provided data was invalid.',
                'details' => $validator->errors(),
            ], 400);
        }

        try {
            $results = [];
            $valid = true;

            foreach ($request->file('files') as $file) {
                $name = $file->getClientOriginalName();
                $content = file_get_contents($file->getRealPath(), false, null, 0, 4000);
                
                if (preg_match('/SerializedMetadata=\"(.+?)\"/', $content, $matches)) {
                    $metadata = base64_decode($matches[1]);
                    
                    // Extract coordinates and scale
                    $lat = unpack("d", substr($metadata, (strlen($metadata) - 92), 8));
                    $long = unpack("d", substr($metadata, (strlen($metadata) - 83), 8));
                    $scale = unpack("d", substr($metadata, (strlen($metadata) - 25), 8));
                    
                    $results[] = [
                        'name' => $name,
                        'valid' => true,
                        'metadata' => [
                            'latitude' => $lat[1],
                            'longitude' => $long[1],
                            'scale' => $scale[1],
                        ],
                    ];
                } else {
                    $valid = false;
                    $results[] = [
                        'name' => $name,
                        'valid' => false,
                        'error' => 'No location metadata found',
                    ];
                }
            }

            return response()->json([
                'valid' => $valid,
                'files' => $results,
            ]);
        } catch (\Exception $e) {
            Log::error('API file validation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}