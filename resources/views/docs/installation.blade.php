@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="prose prose-indigo max-w-none">
                    <h1>Installation Guide</h1>
                    
                    <p class="lead">
                        This guide explains how to install and set up the Google Earth VR Custom Tour Generator on your own server.
                    </p>
                    
                    <nav class="bg-gray-50 p-4 rounded-lg my-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-2">On this page</h2>
                        <ul class="space-y-1">
                            <li><a href="#docker" class="text-indigo-600 hover:text-indigo-500">Docker Installation (Recommended)</a></li>
                            <li><a href="#manual" class="text-indigo-600 hover:text-indigo-500">Manual Installation</a></li>
                            <li><a href="#google-maps-api" class="text-indigo-600 hover:text-indigo-500">Google Maps API Setup</a></li>
                            <li><a href="#configuration" class="text-indigo-600 hover:text-indigo-500">Configuration Options</a></li>
                            <li><a href="#deployment" class="text-indigo-600 hover:text-indigo-500">Deployment Options</a></li>
                        </ul>
                    </nav>
                    
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 my-6">
                        <h3 class="text-yellow-800 font-medium">Note</h3>
                        <p class="text-yellow-700">
                            If you just want to use the application without installing it, you can use the online version at <a href="https://earthvr-custom-tours.app" class="text-yellow-800 underline" target="_blank" rel="noopener noreferrer">https://earthvr-custom-tours.app</a>.
                        </p>
                    </div>
                    
                    <h2 id="docker" class="scroll-mt-24">Docker Installation (Recommended)</h2>
                    
                    <p>
                        The easiest way to install the Google Earth VR Custom Tour Generator is using Docker. This method requires minimal setup and ensures consistent behavior across different environments.
                    </p>
                    
                    <h3>Prerequisites</h3>
                    
                    <ul>
                        <li>Docker installed on your system</li>
                        <li>Docker Compose (optional, but recommended)</li>
                        <li>A Google Maps API key (see <a href="#google-maps-api">Google Maps API Setup</a>)</li>
                    </ul>
                    
                    <h3>Quick Start with Docker Run</h3>
                    
                    <p>
                        To quickly start the application with Docker, run the following command:
                    </p>
                    
                    <pre><code>docker run -p 80:80 \
    -e MAPS_API_KEY=your_google_maps_api_key \
    thrnz/earthvr-custom-tours</code></pre>
                    
                    <p>
                        Replace <code>your_google_maps_api_key</code> with your actual Google Maps API key.
                    </p>
                    
                    <h3>Using Docker Compose (Recommended)</h3>
                    
                    <p>
                        For more advanced configuration, you can use Docker Compose:
                    </p>
                    
                    <ol>
                        <li>
                            <p>Clone the repository:</p>
                            <pre><code>git clone https://github.com/thrnz/earthvr-custom-tours.git
cd earthvr-custom-tours</code></pre>
                        </li>
                        <li>
                            <p>Create a .env file:</p>
                            <pre><code>cp .env.example .env</code></pre>
                        </li>
                        <li>
                            <p>Edit the .env file and add your Google Maps API key:</p>
                            <pre><code>MAPS_API_KEY=your_google_maps_api_key</code></pre>
                        </li>
                        <li>
                            <p>Start the application:</p>
                            <pre><code>docker-compose up -d</code></pre>
                        </li>
                    </ol>
                    
                    <p>
                        The application will be available at <a href="http://localhost" class="text-indigo-600 hover:text-indigo-500">http://localhost</a>.
                    </p>
                    
                    <h3>Docker Compose with Redis Cache</h3>
                    
                    <p>
                        For better performance, you can use Redis for caching:
                    </p>
                    
                    <pre><code>version: '3.8'

services:
  app:
    image: thrnz/earthvr-custom-tours:latest
    ports:
      - "80:80"
    environment:
      - MAPS_API_KEY=your_google_maps_api_key
      - CACHE_DRIVER=redis
      - REDIS_HOST=redis
    depends_on:
      - redis
    restart: unless-stopped

  redis:
    image: redis:alpine
    volumes:
      - redis-data:/data
    restart: unless-stopped

volumes:
  redis-data:</code></pre>
                    
                    <h2 id="manual" class="scroll-mt-24 mt-12">Manual Installation</h2>
                    
                    <p>
                        If you prefer to install the application manually, follow these steps:
                    </p>
                    
                    <h3>Prerequisites</h3>
                    
                    <ul>
                        <li>PHP 8.2 or higher</li>
                        <li>Composer</li>
                        <li>Node.js 20 or higher</li>
                        <li>npm</li>
                        <li>A web server (Apache, Nginx, etc.)</li>
                        <li>Redis (optional, for caching)</li>
                    </ul>
                    
                    <h3>Installation Steps</h3>
                    
                    <ol>
                        <li>
                            <p>Clone the repository:</p>
                            <pre><code>git clone https://github.com/thrnz/earthvr-custom-tours.git
cd earthvr-custom-tours</code></pre>
                        </li>
                        <li>
                            <p>Install PHP dependencies:</p>
                            <pre><code>composer install --no-dev --optimize-autoloader</code></pre>
                        </li>
                        <li>
                            <p>Install JavaScript dependencies:</p>
                            <pre><code>npm install</code></pre>
                        </li>
                        <li>
                            <p>Build frontend assets:</p>
                            <pre><code>npm run build</code></pre>
                        </li>
                        <li>
                            <p>Create environment file:</p>
                            <pre><code>cp .env.example .env</code></pre>
                        </li>
                        <li>
                            <p>Generate application key:</p>
                            <pre><code>php artisan key:generate</code></pre>
                        </li>
                        <li>
                            <p>Edit the .env file and add your Google Maps API key:</p>
                            <pre><code>MAPS_API_KEY=your_google_maps_api_key</code></pre>
                        </li>
                        <li>
                            <p>Configure your web server to point to the public directory.</p>
                        </li>
                    </ol>
                    
                    <h3>Web Server Configuration</h3>
                    
                    <h4>Apache</h4>
                    
                    <p>
                        Create a virtual host configuration:
                    </p>
                    
                    <pre><code>&lt;VirtualHost *:80&gt;
    ServerName earthvr-custom-tours.local
    DocumentRoot /path/to/earthvr-custom-tours/public
    
    &lt;Directory /path/to/earthvr-custom-tours/public&gt;
        AllowOverride All
        Require all granted
    &lt;/Directory&gt;
    
    ErrorLog ${APACHE_LOG_DIR}/earthvr-custom-tours-error.log
    CustomLog ${APACHE_LOG_DIR}/earthvr-custom-tours-access.log combined
&lt;/VirtualHost&gt;</code></pre>
                    
                    <h4>Nginx</h4>
                    
                    <p>
                        Create a server configuration:
                    </p>
                    
                    <pre><code>server {
    listen 80;
    server_name earthvr-custom-tours.local;
    root /path/to/earthvr-custom-tours/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}</code></pre>
                    
                    <h2 id="google-maps-api" class="scroll-mt-24 mt-12">Google Maps API Setup</h2>
                    
                    <p>
                        The application requires a Google Maps API key to retrieve elevation data. Follow these steps to obtain one:
                    </p>
                    
                    <ol>
                        <li>
                            <p>Go to the <a href="https://console.cloud.google.com/" class="text-indigo-600 hover:text-indigo-500" target="_blank" rel="noopener noreferrer">Google Cloud Console</a>.</p>
                        </li>
                        <li>
                            <p>Create a new project or select an existing one.</p>
                        </li>
                        <li>
                            <p>Navigate to "APIs & Services" > "Library".</p>
                        </li>
                        <li>
                            <p>Search for "Elevation API" and enable it.</p>
                        </li>
                        <li>
                            <p>Go to "APIs & Services" > "Credentials".</p>
                        </li>
                        <li>
                            <p>Click "Create credentials" > "API key".</p>
                        </li>
                        <li>
                            <p>Copy the generated API key.</p>
                        </li>
                        <li>
                            <p>(Optional but recommended) Restrict the API key to only the Elevation API and your server's IP address.</p>
                        </li>
                    </ol>
                    
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 my-6">
                        <h3 class="text-blue-800 font-medium">Important</h3>
                        <p class="text-blue-700">
                            The Google Maps API is not free for all usage levels. You get a monthly $200 credit, which should be sufficient for moderate use. Monitor your usage in the Google Cloud Console to avoid unexpected charges.
                        </p>
                    </div>
                    
                    <h2 id="configuration" class="scroll-mt-24 mt-12">Configuration Options</h2>
                    
                    <p>
                        The application can be configured through environment variables in the .env file:
                    </p>
                    
                    <table class="min-w-full divide-y divide-gray-300 mt-4">
                        <thead>
                            <tr>
                                <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Variable</th>
                                <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Description</th>
                                <th scope="col" class="py-2 px-4 text-left text-sm font-semibold text-gray-900 bg-gray-50">Default</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">MAPS_API_KEY</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Google Maps API key</td>
                                <td class="py-2 px-4 text-sm text-gray-500">None (required)</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">MAX_UPLOAD_SIZE</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Maximum file size in MB</td>
                                <td class="py-2 px-4 text-sm text-gray-500">64</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">MAX_FILE_UPLOADS</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Maximum number of files</td>
                                <td class="py-2 px-4 text-sm text-gray-500">500</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">DEFAULT_DELAY</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Default delay time (seconds)</td>
                                <td class="py-2 px-4 text-sm text-gray-500">25</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">DEFAULT_INIT_TIME</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Default starting hour</td>
                                <td class="py-2 px-4 text-sm text-gray-500">12</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">DEFAULT_END_TIME</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Default ending hour</td>
                                <td class="py-2 px-4 text-sm text-gray-500">15</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">CACHE_DRIVER</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Cache driver (file, redis)</td>
                                <td class="py-2 px-4 text-sm text-gray-500">file</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">REDIS_HOST</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Redis host</td>
                                <td class="py-2 px-4 text-sm text-gray-500">127.0.0.1</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">REDIS_PASSWORD</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Redis password</td>
                                <td class="py-2 px-4 text-sm text-gray-500">null</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm text-gray-900">REDIS_PORT</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Redis port</td>
                                <td class="py-2 px-4 text-sm text-gray-500">6379</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h2 id="deployment" class="scroll-mt-24 mt-12">Deployment Options</h2>
                    
                    <p>
                        The application can be deployed to various platforms:
                    </p>
                    
                    <h3>Google Cloud Run</h3>
                    
                    <p>
                        To deploy to Google Cloud Run:
                    </p>
                    
                    <ol>
                        <li>
                            <p>Build and push the Docker image:</p>
                            <pre><code>docker build -t gcr.io/your-project-id/earthvr-custom-tours .
docker push gcr.io/your-project-id/earthvr-custom-tours</code></pre>
                        </li>
                        <li>
                            <p>Deploy to Cloud Run:</p>
                            <pre><code>gcloud run deploy earthvr-custom-tours \
  --image gcr.io/your-project-id/earthvr-custom-tours \
  --platform managed \
  --region us-central1 \
  --allow-unauthenticated \
  --set-env-vars="MAPS_API_KEY=your_google_maps_api_key"</code></pre>
                        </li>
                    </ol>
                    
                    <h3>Google App Engine</h3>
                    
                    <p>
                        To deploy to Google App Engine:
                    </p>
                    
                    <ol>
                        <li>
                            <p>Ensure you have the app.yaml file configured correctly.</p>
                        </li>
                        <li>
                            <p>Deploy the application:</p>
                            <pre><code>gcloud app deploy</code></pre>
                        </li>
                    </ol>
                    
                    <h3>Other Platforms</h3>
                    
                    <p>
                        The application can also be deployed to other platforms like AWS, Azure, or traditional hosting providers. The Docker container makes it easy to deploy anywhere that supports Docker.
                    </p>
                    
                    <div class="mt-12 p-6 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Need Help?</h3>
                        <p class="text-blue-700">
                            If you encounter any issues during installation or deployment, please check our <a href="{{ route('docs.faq') }}" class="text-blue-600 hover:text-blue-500 underline">FAQ</a> or visit our <a href="https://github.com/thrnz/earthvr-custom-tours/issues" class="text-blue-600 hover:text-blue-500 underline" target="_blank" rel="noopener noreferrer">GitHub Issues</a> page for support.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection