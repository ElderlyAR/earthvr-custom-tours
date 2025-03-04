@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="prose prose-indigo max-w-none">
                    <h1>Documentation</h1>
                    
                    <p class="lead">
                        Welcome to the Google Earth VR Custom Tour Generator documentation. This guide will help you understand how to use the application to create custom tours for Google Earth VR.
                    </p>
                    
                    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <a href="{{ route('docs.installation') }}" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition duration-150">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Installation</h3>
                            <p class="text-gray-600">Learn how to install and set up the application on your own server.</p>
                        </a>
                        
                        <a href="{{ route('docs.usage') }}" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition duration-150">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Usage Guide</h3>
                            <p class="text-gray-600">Step-by-step instructions for creating and using custom tours.</p>
                        </a>
                        
                        <a href="{{ route('docs.api') }}" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition duration-150">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">API Reference</h3>
                            <p class="text-gray-600">Documentation for the programmatic API endpoints.</p>
                        </a>
                        
                        <a href="{{ route('docs.faq') }}" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition duration-150">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">FAQ</h3>
                            <p class="text-gray-600">Frequently asked questions and troubleshooting tips.</p>
                        </a>
                    </div>
                    
                    <h2 class="mt-12">Quick Start</h2>
                    
                    <ol>
                        <li>In Google Earth VR, save locations by pressing the 'star' button on the globe controller.</li>
                        <li>Locate the saved JPG files in your "%Username%/Pictures/Google Earth VR" folder.</li>
                        <li>Upload these JPG files to the application.</li>
                        <li>Configure tour settings (duration, time of day, tour name).</li>
                        <li>Click "Generate Tour" to download the earthVR.textpb file.</li>
                        <li>Create a folder in your Google Earth VR installation directory:
                            <pre><code>SteamApps/Common/EarthVR/assets/content/tours/your_tour_name</code></pre>
                        </li>
                        <li>Place the downloaded file in this folder.</li>
                        <li>Launch Google Earth VR and find your tour in the menu.</li>
                    </ol>
                    
                    <h2 class="mt-8">Features</h2>
                    
                    <ul>
                        <li><strong>Custom Locations</strong>: Include any location you can visit in Google Earth VR.</li>
                        <li><strong>Time Control</strong>: Set the time of day for each destination.</li>
                        <li><strong>Duration Control</strong>: Specify how long to stay at each location.</li>
                        <li><strong>Audio Support</strong>: Add background and location-specific audio.</li>
                        <li><strong>Ordering</strong>: Control the order of destinations by renaming the JPG files.</li>
                    </ul>
                    
                    <h2 class="mt-8">System Requirements</h2>
                    
                    <p>To use the generated tours, you need:</p>
                    
                    <ul>
                        <li>Google Earth VR installed via Steam</li>
                        <li>A compatible VR headset (Valve Index, HTC Vive, Oculus Rift, etc.)</li>
                        <li>A VR-ready PC</li>
                    </ul>
                    
                    <div class="mt-12 p-6 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Need Help?</h3>
                        <p class="text-blue-700 mb-4">
                            If you have any questions or run into issues, check out the <a href="{{ route('docs.faq') }}" class="text-blue-600 hover:text-blue-500 underline">FAQ</a> or visit our <a href="https://github.com/thrnz/earthvr-custom-tours/issues" class="text-blue-600 hover:text-blue-500 underline" target="_blank" rel="noopener noreferrer">GitHub Issues</a> page.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection