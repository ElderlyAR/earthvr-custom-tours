@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Google Earth VR Custom Tour Generator</h1>
                
                <p class="mb-6 text-lg text-gray-700">
                    This tool allows you to create your own custom tours in Google Earth VR. It's just like the included tours (Cities, Landmarks, Colors etc.), but with your own set of locations.
                </p>
                
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('tours.process') }}" method="post" enctype="multipart/form-data" class="space-y-8" x-data="tourForm()">
                    @csrf
                    
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Preparation</h2>
                        <p class="text-gray-700 mb-4">
                            First, save the destinations you want to include in Google Earth VR itself using the 'star' button on the globe controller. They will appear as .JPG files in your "%Username%/Pictures/Google Earth VR" folder.
                        </p>
                        <div class="flex items-center">
                            <svg class="h-8 w-8 text-indigo-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-gray-500">
                                The order of destinations in your tour will be determined by the filenames. If the order matters to you, rename the JPG files before uploading.
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Step 1: Upload Destination Images</h2>
                        <p class="text-gray-700 mb-4">
                            Attach the JPG files of the destinations you want to include. You can select multiple files using Ctrl or Shift.
                        </p>
                        
                        <div class="mt-2">
                            <div
                                x-data="filepond()"
                                x-init="initFilepond($refs.input)"
                                class="filepond-container"
                            >
                                <input
                                    type="file"
                                    x-ref="input"
                                    name="destinations[]"
                                    multiple
                                    accept="image/jpeg"
                                    class="filepond"
                                />
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Maximum file size: {{ $maxUploadSize }}MB. Maximum number of files: {{ $maxFileUploads }}.
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Step 2: Configure Tour Settings</h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="delay" class="block text-sm font-medium text-gray-700">
                                    How long to stay at each destination (in seconds):
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm max-w-xs">
                                    <input
                                        type="number"
                                        name="delay"
                                        id="delay"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md"
                                        placeholder="25"
                                        value="{{ old('delay', $defaultDelay) }}"
                                        min="1"
                                        max="300"
                                    >
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">sec</span>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    This determines how long the tour will stay at each location before moving to the next one.
                                </p>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label for="init_time" class="block text-sm font-medium text-gray-700">
                                        Starting time of day (hour, 0-23):
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            type="number"
                                            name="init_time"
                                            id="init_time"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="12"
                                            value="{{ old('init_time', $defaultInitTime) }}"
                                            min="0"
                                            max="23"
                                        >
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">
                                        The approximate local hour when arriving at each destination.
                                    </p>
                                </div>
                                
                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700">
                                        Ending time of day (hour, 0-23):
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            type="number"
                                            name="end_time"
                                            id="end_time"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="15"
                                            value="{{ old('end_time', $defaultEndTime) }}"
                                            min="0"
                                            max="23"
                                        >
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">
                                        The approximate local hour when leaving each destination.
                                    </p>
                                </div>
                            </div>
                            
                            <div>
                                <label for="tourname" class="block text-sm font-medium text-gray-700">
                                    Tour Name:
                                </label>
                                <div class="mt-1">
                                    <input
                                        type="text"
                                        name="tourname"
                                        id="tourname"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="My Custom Tour"
                                        value="{{ old('tourname', 'Custom') }}"
                                        maxlength="255"
                                    >
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    This name will appear in the Google Earth VR menu.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Step 3: Generate Tour</h2>
                        <p class="text-gray-700 mb-4">
                            Click below to generate the tour file. Simply place it in the "SteamApps/Common/EarthVR/assets/content/tours/custom_tour_name" folder (you'll need to create this folder) and you're good to go!
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <button
                                type="submit"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                x-bind:disabled="isSubmitting"
                            >
                                <span x-show="!isSubmitting">Generate Tour!</span>
                                <span x-show="isSubmitting" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                            
                            <a href="{{ route('docs.usage') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                                Need help? View the documentation
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-amber-50 p-6 rounded-lg border border-amber-200">
                        <h2 class="text-xl font-semibold text-amber-800 mb-4">Limitations and Notes</h2>
                        <ul class="space-y-3 text-amber-700">
                            <li class="flex">
                                <svg class="flex-shrink-0 h-5 w-5 text-amber-500 mt-1 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>If you save a destination that is too close to the ground, then you may appear underground when it appears during the tour. This is because we're not able to pull the appropriate elevation data from the JPG metadata, and rely on data from the Google Maps Elevation API instead.</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 h-5 w-5 text-amber-500 mt-1 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>To include looping background audio, place an .ogg file named 'bgaudio1.ogg' in the same folder as earthVR.textpb. This will play throughout the entire tour.</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 h-5 w-5 text-amber-500 mt-1 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>To include destination specific audio, place a DESTNAME.ogg file in the same folder as earthVR.textpb, where DESTNAME is the name of the corresponding .JPG. Eg: include 'Christchurch_Central.ogg' to play audio when visiting 'Christchurch_Central.jpg'.</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 h-5 w-5 text-amber-500 mt-1 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>You may experience a lack of audio when using filenames with non-standard characters. This may be an issue with both .ogg files and the tour's folder name itself. You may need to manually edit the tour file's 'audio_resource' entries in order to fix this.</span>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

@push('scripts')
<script>
    function tourForm() {
        return {
            isSubmitting: false,
            
            submitForm() {
                this.isSubmitting = true;
            }
        }
    }
    
    function filepond() {
        return {
            initFilepond(input) {
                // Register plugins
                FilePond.registerPlugin(
                    FilePondPluginFileValidateType,
                    FilePondPluginFileValidateSize,
                    FilePondPluginImagePreview
                );
                
                // Create FilePond instance
                const pond = FilePond.create(input, {
                    acceptedFileTypes: ['image/jpeg'],
                    allowMultiple: true,
                    maxFiles: {{ $maxFileUploads }},
                    maxFileSize: '{{ $maxUploadSize }}MB',
                    labelIdle: 'Drag & drop your JPG files or <span class="filepond--label-action">Browse</span>',
                    labelFileTypeNotAllowed: 'Only JPG files are allowed',
                    fileValidateTypeLabelExpectedTypes: 'Only JPG files are allowed',
                    labelMaxFileSizeExceeded: 'File is too large',
                    labelMaxFileSize: 'Maximum file size is {filesize}',
                    labelMaxTotalFileSize: 'Maximum total size exceeded',
                    labelMaxTotalFileSizeExceeded: 'Maximum total size exceeded',
                    credits: false,
                });
            }
        }
    }
</script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
@endpush