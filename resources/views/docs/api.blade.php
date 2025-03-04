@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="prose prose-indigo max-w-none">
                    <h1>API Documentation</h1>
                    
                    <p class="lead">
                        This page documents the API endpoints available for programmatic interaction with the Google Earth VR Custom Tour Generator.
                    </p>
                    
                    <div class="bg-gray-50 p-4 rounded-lg my-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-2">Authentication</h2>
                        <p class="text-gray-700">
                            API requests require authentication using an API key. To obtain an API key, please contact the administrator.
                        </p>
                        <p class="text-gray-700 mt-2">
                            Include your API key in the request header:
                        </p>
                        <pre><code>Authorization: Bearer YOUR_API_KEY</code></pre>
                    </div>
                    
                    <h2 class="mt-12">Endpoints</h2>
                    
                    <div class="space-y-12">
                        <!-- Generate Tour Endpoint -->
                        <div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded mr-2">POST</span>
                                <h3 class="text-xl font-semibold">/api/tours/generate</h3>
                            </div>
                            
                            <p class="mt-2">
                                Generates a custom tour file based on the provided JPG files and settings.
                            </p>
                            
                            <h4 class="font-medium mt-4">Request</h4>
                            
                            <p>Content-Type: <code>multipart/form-data</code></p>
                            
                            <h5 class="font-medium mt-2">Parameters</h5>
                            
                            <table class="min-w-full divide-y divide-gray-300 mt-2">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Name</th>
                                        <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Type</th>
                                        <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Required</th>
                                        <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-2 px-4 text-sm text-gray-900">destinations[]</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">File</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Yes</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">JPG files from Google Earth VR</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-4 text-sm text-gray-900">delay</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Integer</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Yes</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Duration at each location (seconds)</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-4 text-sm text-gray-900">init_time</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Integer</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Yes</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Starting hour (0-23)</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-4 text-sm text-gray-900">end_time</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Integer</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Yes</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Ending hour (0-23)</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-4 text-sm text-gray-900">tourname</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">String</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Yes</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Name of the tour</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <h4 class="font-medium mt-6">Response</h4>
                            
                            <p>Content-Type: <code>application/octet-stream</code></p>
                            <p>Content-Disposition: <code>attachment; filename=earthVR.textpb</code></p>
                            
                            <h5 class="font-medium mt-2">Success Response (200 OK)</h5>
                            
                            <p>
                                Returns the generated tour file as a download.
                            </p>
                            
                            <h5 class="font-medium mt-4">Error Responses</h5>
                            
                            <p class="mt-2"><strong>400 Bad Request</strong></p>
                            <pre><code>{
  "error": "Validation failed",
  "message": "The destinations field is required.",
  "details": {
    "destinations": ["The destinations field is required."]
  }
}</code></pre>
                            
                            <p class="mt-4"><strong>401 Unauthorized</strong></p>
                            <pre><code>{
  "error": "Unauthorized",
  "message": "Invalid API key"
}</code></pre>
                            
                            <p class="mt-4"><strong>500 Internal Server Error</strong></p>
                            <pre><code>{
  "error": "Server error",
  "message": "Unable to fetch elevation data"
}</code></pre>
                            
                            <h4 class="font-medium mt-6">Example</h4>
                            
                            <p>Using cURL:</p>
                            
                            <pre><code>curl -X POST \
  https://earthvr-custom-tours.app/api/tours/generate \
  -H 'Authorization: Bearer YOUR_API_KEY' \
  -H 'Content-Type: multipart/form-data' \
  -F 'destinations[]=@/path/to/location1.jpg' \
  -F 'destinations[]=@/path/to/location2.jpg' \
  -F 'delay=25' \
  -F 'init_time=12' \
  -F 'end_time=15' \
  -F 'tourname=My Custom Tour' \
  --output earthVR.textpb</code></pre>
                        </div>
                        
                        <!-- Get Tour Info Endpoint -->
                        <div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded mr-2">GET</span>
                                <h3 class="text-xl font-semibold">/api/tours/validate</h3>
                            </div>
                            
                            <p class="mt-2">
                                Validates JPG files to ensure they contain the required metadata for tour generation.
                            </p>
                            
                            <h4 class="font-medium mt-4">Request</h4>
                            
                            <p>Content-Type: <code>multipart/form-data</code></p>
                            
                            <h5 class="font-medium mt-2">Parameters</h5>
                            
                            <table class="min-w-full divide-y divide-gray-300 mt-2">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Name</th>
                                        <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Type</th>
                                        <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Required</th>
                                        <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-2 px-4 text-sm text-gray-900">files[]</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">File</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">Yes</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">JPG files to validate</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <h4 class="font-medium mt-6">Response</h4>
                            
                            <p>Content-Type: <code>application/json</code></p>
                            
                            <h5 class="font-medium mt-2">Success Response (200 OK)</h5>
                            
                            <pre><code>{
  "valid": true,
  "files": [
    {
      "name": "Paris_Eiffel_Tower.jpg",
      "valid": true,
      "metadata": {
        "latitude": 48.8584,
        "longitude": 2.2945,
        "scale": 1000
      }
    },
    {
      "name": "London_Big_Ben.jpg",
      "valid": true,
      "metadata": {
        "latitude": 51.5007,
        "longitude": -0.1246,
        "scale": 800
      }
    }
  ]
}</code></pre>
                            
                            <h5 class="font-medium mt-4">Error Response</h5>
                            
                            <pre><code>{
  "valid": false,
  "files": [
    {
      "name": "Paris_Eiffel_Tower.jpg",
      "valid": true,
      "metadata": {
        "latitude": 48.8584,
        "longitude": 2.2945,
        "scale": 1000
      }
    },
    {
      "name": "invalid_file.jpg",
      "valid": false,
      "error": "No location metadata found"
    }
  ]
}</code></pre>
                        </div>
                    </div>
                    
                    <h2 class="mt-12">Rate Limiting</h2>
                    
                    <p>
                        API requests are rate-limited to protect our servers from excessive use. The current limits are:
                    </p>
                    
                    <ul>
                        <li>60 requests per minute</li>
                        <li>1000 requests per day</li>
                    </ul>
                    
                    <p>
                        If you exceed these limits, you'll receive a 429 Too Many Requests response with a Retry-After header indicating how many seconds to wait before making another request.
                    </p>
                    
                    <h2 class="mt-12">Errors</h2>
                    
                    <p>
                        All error responses follow this format:
                    </p>
                    
                    <pre><code>{
  "error": "Error type",
  "message": "Human-readable error message",
  "details": {
    // Additional error details (optional)
  }
}</code></pre>
                    
                    <h3 class="mt-4">Common Error Codes</h3>
                    
                    <table class="min-w-full divide-y divide-gray-300 mt-2">
                        <thead>
                            <tr>
                                <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Status Code</th>
                                <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Error Type</th>
                                <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Description</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">400</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Bad Request</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Invalid request parameters</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">401</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Unauthorized</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Missing or invalid API key</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">403</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Forbidden</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Insufficient permissions</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">404</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Not Found</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Resource not found</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">429</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Too Many Requests</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Rate limit exceeded</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">500</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Server Error</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Internal server error</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h2 class="mt-12">Need Help?</h2>
                    
                    <p>
                        If you have any questions or need assistance with the API, please contact us at <a href="mailto:api-support@earthvr-custom-tours.app" class="text-indigo-600 hover:text-indigo-500">api-support@earthvr-custom-tours.app</a> or visit our <a href="https://github.com/thrnz/earthvr-custom-tours/issues" class="text-indigo-600 hover:text-indigo-500" target="_blank" rel="noopener noreferrer">GitHub Issues</a> page.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection