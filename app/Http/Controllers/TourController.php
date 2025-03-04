<?php

namespace App\Http\Controllers;

use App\Services\TourGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    protected $tourGenerator;

    public function __construct(TourGeneratorService $tourGenerator)
    {
        $this->tourGenerator = $tourGenerator;
    }

    /**
     * Show the tour generator form
     */
    public function index()
    {
        return view('tours.index', [
            'defaultDelay' => config('tour.default_delay', 25),
            'defaultInitTime' => config('tour.default_init_time', 12),
            'defaultEndTime' => config('tour.default_end_time', 15),
            'maxUploadSize' => config('tour.max_upload_size', 64),
            'maxFileUploads' => config('tour.max_file_uploads', 500),
        ]);
    }

    /**
     * Process the tour generation request
     */
    public function process(Request $request)
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
            return redirect()->route('tours.index')
                ->withErrors($validator)
                ->withInput();
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
            Log::error('Tour generation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            return redirect()->route('tours.index')
                ->with('error', 'Tour generation failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Health check endpoint for App Engine
     */
    public function health()
    {
        // Check if we can connect to Redis
        try {
            Cache::has('health-check');
            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Health check failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}