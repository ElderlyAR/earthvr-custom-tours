<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Tour Settings
    |--------------------------------------------------------------------------
    |
    | These values are used as defaults for the tour generator form.
    |
    */

    'default_delay' => env('DEFAULT_DELAY', 25),
    'default_init_time' => env('DEFAULT_INIT_TIME', 12),
    'default_end_time' => env('DEFAULT_END_TIME', 15),

    /*
    |--------------------------------------------------------------------------
    | Upload Limits
    |--------------------------------------------------------------------------
    |
    | Maximum file size (in MB) and number of files that can be uploaded.
    |
    */

    'max_upload_size' => env('MAX_UPLOAD_SIZE', 64),
    'max_file_uploads' => env('MAX_FILE_UPLOADS', 500),

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Settings for caching elevation data and other tour-related information.
    |
    */

    'cache_ttl' => env('TOUR_CACHE_TTL', 60 * 24 * 30), // 30 days in minutes
];