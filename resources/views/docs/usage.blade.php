@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="prose prose-indigo max-w-none">
                    <h1>Usage Guide</h1>
                    
                    <p class="lead">
                        This guide will walk you through the process of creating and using custom tours in Google Earth VR.
                    </p>
                    
                    <nav class="bg-gray-50 p-4 rounded-lg my-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-2">On this page</h2>
                        <ul class="space-y-1">
                            <li><a href="#saving-locations" class="text-indigo-600 hover:text-indigo-500">Saving Locations in Google Earth VR</a></li>
                            <li><a href="#preparing-files" class="text-indigo-600 hover:text-indigo-500">Preparing Your Files</a></li>
                            <li><a href="#generating-tour" class="text-indigo-600 hover:text-indigo-500">Generating the Tour</a></li>
                            <li><a href="#installing-tour" class="text-indigo-600 hover:text-indigo-500">Installing the Tour</a></li>
                            <li><a href="#adding-audio" class="text-indigo-600 hover:text-indigo-500">Adding Audio</a></li>
                            <li><a href="#troubleshooting" class="text-indigo-600 hover:text-indigo-500">Troubleshooting</a></li>
                        </ul>
                    </nav>
                    
                    <h2 id="saving-locations" class="scroll-mt-24">Saving Locations in Google Earth VR</h2>
                    
                    <p>
                        To create a custom tour, you first need to save the locations you want to include:
                    </p>
                    
                    <ol>
                        <li>Launch Google Earth VR on your VR headset.</li>
                        <li>Navigate to a location you want to include in your tour.</li>
                        <li>Position yourself at the exact viewpoint you want to capture.</li>
                        <li>Press the 'star' button on the globe controller (left-hand controller).</li>
                        <li>You'll see a confirmation that the location has been saved.</li>
                        <li>Repeat for all locations you want to include in your tour.</li>
                    </ol>
                    
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 my-6">
                        <h3 class="text-yellow-800 font-medium">Note</h3>
                        <p class="text-yellow-700">
                            The saved locations are stored as JPG files in your computer's "%Username%/Pictures/Google Earth VR" folder. You'll need to access these files to create your tour.
                        </p>
                    </div>
                    
                    <h2 id="preparing-files" class="scroll-mt-24 mt-12">Preparing Your Files</h2>
                    
                    <p>
                        Before uploading your saved locations to the tour generator, you may want to prepare them:
                    </p>
                    
                    <h3>Ordering Your Destinations</h3>
                    
                    <p>
                        The order of destinations in your tour is determined by the filenames of the JPG files. If the order matters to you, rename the files before uploading them.
                    </p>
                    
                    <p>
                        For example, you could rename your files like this:
                    </p>
                    
                    <ul>
                        <li><code>01_Paris_Eiffel_Tower.jpg</code></li>
                        <li><code>02_London_Big_Ben.jpg</code></li>
                        <li><code>03_New_York_Statue_of_Liberty.jpg</code></li>
                    </ul>
                    
                    <h3>Preparing Audio Files (Optional)</h3>
                    
                    <p>
                        If you want to include audio in your tour, prepare your audio files in OGG format:
                    </p>
                    
                    <ul>
                        <li>For background audio: Create a file named <code>bgaudio1.ogg</code></li>
                        <li>For location-specific audio: Create files named after your JPG files (without the .jpg extension), e.g., <code>01_Paris_Eiffel_Tower.ogg</code></li>
                    </ul>
                    
                    <h2 id="generating-tour" class="scroll-mt-24 mt-12">Generating the Tour</h2>
                    
                    <p>
                        Once you have your JPG files ready, follow these steps to generate your tour:
                    </p>
                    
                    <ol>
                        <li>
                            <strong>Upload Your Files</strong>
                            <p>Drag and drop your JPG files into the upload area, or click to browse and select them.</p>
                        </li>
                        <li>
                            <strong>Configure Tour Settings</strong>
                            <ul>
                                <li><strong>Duration:</strong> Set how long to stay at each destination (in seconds).</li>
                                <li><strong>Starting Time:</strong> Choose what local hour of the day you want each destination to begin at.</li>
                                <li><strong>Ending Time:</strong> Choose what local hour of the day you want each destination to end at.</li>
                                <li><strong>Tour Name:</strong> Give your tour a name that will appear in the Google Earth VR menu.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Generate the Tour</strong>
                            <p>Click the "Generate Tour!" button to create and download the <code>earthVR.textpb</code> file.</p>
                        </li>
                    </ol>
                    
                    <h2 id="installing-tour" class="scroll-mt-24 mt-12">Installing the Tour</h2>
                    
                    <p>
                        To install your custom tour in Google Earth VR:
                    </p>
                    
                    <ol>
                        <li>
                            <strong>Create a Folder</strong>
                            <p>Create a new folder in your Google Earth VR installation directory:</p>
                            <pre><code>SteamApps/Common/EarthVR/assets/content/tours/your_tour_name</code></pre>
                            <p>Replace <code>your_tour_name</code> with a name for your tour (preferably without spaces).</p>
                        </li>
                        <li>
                            <strong>Place the Tour File</strong>
                            <p>Copy the downloaded <code>earthVR.textpb</code> file into the folder you created.</p>
                        </li>
                        <li>
                            <strong>Add Audio Files (Optional)</strong>
                            <p>If you have audio files, place them in the same folder.</p>
                        </li>
                        <li>
                            <strong>Launch Google Earth VR</strong>
                            <p>Start Google Earth VR and look for your tour in the tours menu.</p>
                        </li>
                    </ol>
                    
                    <h2 id="adding-audio" class="scroll-mt-24 mt-12">Adding Audio</h2>
                    
                    <p>
                        You can enhance your tour with audio:
                    </p>
                    
                    <h3>Background Audio</h3>
                    
                    <p>
                        To add background audio that plays throughout the entire tour:
                    </p>
                    
                    <ol>
                        <li>Create an OGG format audio file.</li>
                        <li>Name it <code>bgaudio1.ogg</code>.</li>
                        <li>Place it in the same folder as your <code>earthVR.textpb</code> file.</li>
                    </ol>
                    
                    <h3>Location-Specific Audio</h3>
                    
                    <p>
                        To add audio that plays only at specific locations:
                    </p>
                    
                    <ol>
                        <li>Create an OGG format audio file for each location.</li>
                        <li>Name each file to match the corresponding JPG filename (without the .jpg extension).</li>
                        <li>For example, if your location is saved as <code>Paris_Eiffel_Tower.jpg</code>, name the audio file <code>Paris_Eiffel_Tower.ogg</code>.</li>
                        <li>Place all audio files in the same folder as your <code>earthVR.textpb</code> file.</li>
                    </ol>
                    
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 my-6">
                        <h3 class="text-blue-800 font-medium">Tip</h3>
                        <p class="text-blue-700">
                            Keep audio files relatively short, as they will loop while you're at each location. For background audio, consider using a longer, ambient track that won't be distracting when looped.
                        </p>
                    </div>
                    
                    <h2 id="troubleshooting" class="scroll-mt-24 mt-12">Troubleshooting</h2>
                    
                    <h3>Common Issues</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-medium">Tour Not Appearing in Google Earth VR</h4>
                            <ul>
                                <li>Verify that you created the correct folder structure.</li>
                                <li>Make sure the file is named exactly <code>earthVR.textpb</code>.</li>
                                <li>Try restarting Google Earth VR.</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="font-medium">Appearing Underground at Destinations</h4>
                            <ul>
                                <li>This can happen if the original saved location was too close to the ground.</li>
                                <li>Try saving the location again from a higher altitude.</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="font-medium">Audio Not Playing</h4>
                            <ul>
                                <li>Ensure audio files are in OGG format.</li>
                                <li>Check that filenames match exactly (they are case-sensitive).</li>
                                <li>Avoid special characters in filenames.</li>
                                <li>If using non-standard characters, you may need to manually edit the tour file's 'audio_resource' entries.</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="font-medium">Upload Errors</h4>
                            <ul>
                                <li>Ensure you're uploading JPG files from Google Earth VR.</li>
                                <li>Check that files are not too large (maximum {{ $maxUploadSize ?? 64 }}MB per file).</li>
                                <li>Verify you're not exceeding the maximum number of files ({{ $maxFileUploads ?? 500 }}).</li>
                            </ul>
                        </div>
                    </div>
                    
                    <h3 class="mt-8">Still Having Issues?</h3>
                    
                    <p>
                        If you're still experiencing problems, please check the <a href="{{ route('docs.faq') }}" class="text-indigo-600 hover:text-indigo-500">FAQ</a> or visit our <a href="https://github.com/thrnz/earthvr-custom-tours/issues" class="text-indigo-600 hover:text-indigo-500" target="_blank" rel="noopener noreferrer">GitHub Issues</a> page to report a bug or request help.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection