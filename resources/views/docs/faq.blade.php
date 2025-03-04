@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="prose prose-indigo max-w-none">
                    <h1>Frequently Asked Questions</h1>
                    
                    <p class="lead">
                        Find answers to common questions about the Google Earth VR Custom Tour Generator.
                    </p>
                    
                    <div class="mt-8" x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'general' }">
                        <!-- FAQ Categories -->
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <button
                                    @click="activeTab = 'general'; window.location.hash = 'general'"
                                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'general', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'general' }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                >
                                    General
                                </button>
                                <button
                                    @click="activeTab = 'tour-creation'; window.location.hash = 'tour-creation'"
                                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'tour-creation', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'tour-creation' }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                >
                                    Tour Creation
                                </button>
                                <button
                                    @click="activeTab = 'installation'; window.location.hash = 'installation'"
                                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'installation', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'installation' }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                >
                                    Installation
                                </button>
                                <button
                                    @click="activeTab = 'audio'; window.location.hash = 'audio'"
                                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'audio', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'audio' }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                >
                                    Audio
                                </button>
                                <button
                                    @click="activeTab = 'troubleshooting'; window.location.hash = 'troubleshooting'"
                                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'troubleshooting', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'troubleshooting' }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                >
                                    Troubleshooting
                                </button>
                            </nav>
                        </div>
                        
                        <!-- General FAQs -->
                        <div x-show="activeTab === 'general'" class="mt-8 space-y-8">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">What is the Google Earth VR Custom Tour Generator?</h3>
                                <p class="mt-2 text-gray-600">
                                    The Google Earth VR Custom Tour Generator is a web application that allows you to create custom tours for Google Earth VR using your own saved locations. It generates a tour file that you can add to your Google Earth VR installation to create a personalized tour experience.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Is this an official Google tool?</h3>
                                <p class="mt-2 text-gray-600">
                                    No, this is not an official Google tool. It's a third-party application created by the community to enhance the Google Earth VR experience.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Is this service free to use?</h3>
                                <p class="mt-2 text-gray-600">
                                    Yes, the online service is free to use. You can also self-host the application if you prefer, using the provided Docker image or by setting up the application manually.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">What VR headsets are supported?</h3>
                                <p class="mt-2 text-gray-600">
                                    The custom tours will work with any VR headset that is compatible with Google Earth VR, including Valve Index, HTC Vive, Oculus Rift, and Windows Mixed Reality headsets.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Can I share my custom tours with others?</h3>
                                <p class="mt-2 text-gray-600">
                                    Yes, you can share your custom tours with others. They will need to place the tour file in their Google Earth VR installation directory to use it. Note that if you include audio files, these will need to be shared separately.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Tour Creation FAQs -->
                        <div x-show="activeTab === 'tour-creation'" class="mt-8 space-y-8">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">How do I save locations in Google Earth VR?</h3>
                                <p class="mt-2 text-gray-600">
                                    To save a location in Google Earth VR, navigate to the desired location, position yourself at the viewpoint you want to capture, and press the 'star' button on the globe controller (left-hand controller). The location will be saved as a JPG file in your "%Username%/Pictures/Google Earth VR" folder.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">How many locations can I include in a tour?</h3>
                                <p class="mt-2 text-gray-600">
                                    There is no hard limit on the number of locations you can include in a tour. However, for practical reasons, we recommend keeping tours to a reasonable length (10-20 locations) for the best experience. The application supports uploading up to {{ $maxFileUploads ?? 500 }} files at once.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">How do I control the order of destinations in my tour?</h3>
                                <p class="mt-2 text-gray-600">
                                    The order of destinations in your tour is determined by the filenames of the JPG files. If the order matters to you, rename the files before uploading them. For example, you could use a numbering system like "01_Paris.jpg", "02_London.jpg", etc.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">What does the "time of day" setting do?</h3>
                                <p class="mt-2 text-gray-600">
                                    The time of day settings (starting and ending time) control the simulated time of day at each location. This affects the lighting and shadows in the scene. For example, setting the starting time to 6 and ending time to 9 will simulate sunrise at each location.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Can I edit a tour after creating it?</h3>
                                <p class="mt-2 text-gray-600">
                                    The application doesn't currently provide a way to edit existing tours. If you want to make changes, you'll need to generate a new tour. However, advanced users can manually edit the earthVR.textpb file using a text editor, as it's a human-readable format.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">What file size limits are there for uploads?</h3>
                                <p class="mt-2 text-gray-600">
                                    Each JPG file can be up to {{ $maxUploadSize ?? 64 }}MB in size. The total upload size is limited to prevent server overload, but should be sufficient for most tours.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Installation FAQs -->
                        <div x-show="activeTab === 'installation'" class="mt-8 space-y-8">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Where do I put the generated tour file?</h3>
                                <p class="mt-2 text-gray-600">
                                    Create a new folder in your Google Earth VR installation directory at: <code>SteamApps/Common/EarthVR/assets/content/tours/your_tour_name</code> (replace "your_tour_name" with a name for your tour). Place the downloaded earthVR.textpb file in this folder.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Do I need to restart Google Earth VR after adding a tour?</h3>
                                <p class="mt-2 text-gray-600">
                                    Yes, if Google Earth VR is already running, you'll need to restart it for the new tour to appear in the menu.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Where do I find my tour in Google Earth VR?</h3>
                                <p class="mt-2 text-gray-600">
                                    Your custom tour will appear in the main menu under the "Tours" section, alongside the built-in tours like "Cities" and "Landmarks".
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Can I have multiple custom tours installed?</h3>
                                <p class="mt-2 text-gray-600">
                                    Yes, you can have multiple custom tours installed simultaneously. Just create a separate folder for each tour in the tours directory.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">How do I remove a custom tour?</h3>
                                <p class="mt-2 text-gray-600">
                                    To remove a custom tour, simply delete its folder from the Google Earth VR tours directory.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Audio FAQs -->
                        <div x-show="activeTab === 'audio'" class="mt-8 space-y-8">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">What audio formats are supported?</h3>
                                <p class="mt-2 text-gray-600">
                                    Google Earth VR supports OGG format audio files. Other formats like MP3 or WAV will not work.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">How do I add background music to my tour?</h3>
                                <p class="mt-2 text-gray-600">
                                    To add background music that plays throughout the entire tour, create an OGG format audio file named "bgaudio1.ogg" and place it in the same folder as your earthVR.textpb file.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">How do I add location-specific audio?</h3>
                                <p class="mt-2 text-gray-600">
                                    To add audio that plays only at specific locations, create OGG format audio files named to match your JPG filenames (without the .jpg extension). For example, if your location is saved as "Paris_Eiffel_Tower.jpg", name the audio file "Paris_Eiffel_Tower.ogg". Place these files in the same folder as your earthVR.textpb file.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">How long should my audio files be?</h3>
                                <p class="mt-2 text-gray-600">
                                    For location-specific audio, it's best to match the duration to the time you'll spend at each location (set by the "delay" parameter). For background audio, longer tracks work well as they will loop throughout the tour.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Why isn't my audio playing?</h3>
                                <p class="mt-2 text-gray-600">
                                    If your audio isn't playing, check that:
                                    <ul class="list-disc pl-5 mt-2">
                                        <li>The files are in OGG format</li>
                                        <li>The filenames match exactly (they are case-sensitive)</li>
                                        <li>The files are in the same folder as the earthVR.textpb file</li>
                                        <li>You don't have special characters in the filenames</li>
                                    </ul>
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">How do I convert audio to OGG format?</h3>
                                <p class="mt-2 text-gray-600">
                                    You can convert audio files to OGG format using free tools like <a href="https://www.audacityteam.org/" target="_blank" rel="noopener noreferrer" class="text-indigo-600 hover:text-indigo-500">Audacity</a> or online converters like <a href="https://audio.online-convert.com/convert-to-ogg" target="_blank" rel="noopener noreferrer" class="text-indigo-600 hover:text-indigo-500">Online-Convert</a>.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Troubleshooting FAQs -->
                        <div x-show="activeTab === 'troubleshooting'" class="mt-8 space-y-8">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">My tour doesn't appear in Google Earth VR</h3>
                                <p class="mt-2 text-gray-600">
                                    If your tour doesn't appear in Google Earth VR, check that:
                                    <ul class="list-disc pl-5 mt-2">
                                        <li>You've placed the earthVR.textpb file in the correct directory</li>
                                        <li>The file is named exactly "earthVR.textpb" (case-sensitive)</li>
                                        <li>You've restarted Google Earth VR after adding the tour</li>
                                        <li>The tour folder name doesn't contain special characters</li>
                                    </ul>
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">I appear underground at some locations</h3>
                                <p class="mt-2 text-gray-600">
                                    This can happen if the original saved location was too close to the ground. The application uses the Google Maps Elevation API to determine the elevation, which may not exactly match the elevation data in Google Earth VR. To fix this, try saving the location again from a higher altitude.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">The upload fails or times out</h3>
                                <p class="mt-2 text-gray-600">
                                    If you're having trouble uploading files, try:
                                    <ul class="list-disc pl-5 mt-2">
                                        <li>Uploading fewer files at once</li>
                                        <li>Ensuring each file is under the {{ $maxUploadSize ?? 64 }}MB limit</li>
                                        <li>Using a more stable internet connection</li>
                                        <li>Using a different browser</li>
                                    </ul>
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">The tour generation fails with an error</h3>
                                <p class="mt-2 text-gray-600">
                                    If tour generation fails, it could be due to:
                                    <ul class="list-disc pl-5 mt-2">
                                        <li>Missing or invalid metadata in the JPG files</li>
                                        <li>Issues with the Google Maps Elevation API</li>
                                        <li>Server-side problems</li>
                                    </ul>
                                    Try again with different files or try again later. If the problem persists, please report it on our <a href="https://github.com/thrnz/earthvr-custom-tours/issues" target="_blank" rel="noopener noreferrer" class="text-indigo-600 hover:text-indigo-500">GitHub Issues</a> page.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">The transitions between locations are too abrupt</h3>
                                <p class="mt-2 text-gray-600">
                                    The application adds fade effects between locations to make transitions smoother. If you find them too abrupt, you can manually edit the earthVR.textpb file to adjust the fade timing or add additional effects.
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">I'm experiencing motion sickness during the tour</h3>
                                <p class="mt-2 text-gray-600">
                                    If you're experiencing motion sickness, try:
                                    <ul class="list-disc pl-5 mt-2">
                                        <li>Increasing the delay time between locations to give yourself more time to adjust</li>
                                        <li>Taking breaks between locations</li>
                                        <li>Ensuring your VR system is running at a stable frame rate</li>
                                        <li>Using the comfort settings in Google Earth VR</li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-12 p-6 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Still Have Questions?</h3>
                        <p class="text-blue-700">
                            If you couldn't find the answer to your question, please check our <a href="{{ route('docs.usage') }}" class="text-blue-600 hover:text-blue-500 underline">Usage Guide</a> for more detailed information or visit our <a href="https://github.com/thrnz/earthvr-custom-tours/issues" class="text-blue-600 hover:text-blue-500 underline" target="_blank" rel="noopener noreferrer">GitHub Issues</a> page to ask a question or report a problem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection