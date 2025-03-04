# Google Earth VR Custom Tour Generator

A modern custom tour generator for Google Earth VR that allows you to create personalized tours with your own set of locations.

![Google Earth VR Custom Tour Generator](https://raw.githubusercontent.com/thrnz/earthvr-custom-tours/main/public/images/screenshot.png)

## Overview

This application allows you to create custom tours for Google Earth VR similar to the included tours (Cities, Landmarks, Colors, etc.), but with your own set of locations. The process is simple:

1. Save destinations in Google Earth VR using the 'star' button
2. Upload the saved JPG files to this application
3. Configure tour settings (duration, time of day, etc.)
4. Generate and download the tour file
5. Place the file in your Google Earth VR directory

## Features

- **Modern UI**: Responsive design with Tailwind CSS and Alpine.js
- **Drag & Drop Uploads**: Easy file uploading with FilePond
- **Tour Customization**: Configure duration, time of day, and more
- **Audio Support**: Add background and location-specific audio
- **Elevation Data**: Automatically retrieves elevation data via Google Maps API
- **Caching**: Efficient caching of API responses for better performance
- **Responsive Design**: Works on all device sizes
- **Accessibility**: WCAG compliant with proper ARIA attributes
- **Security**: Input validation, CSRF protection, and more

## Self-Hosting

### Using Docker (Recommended)

A pre-built Docker image is available for easy self-hosting. You'll need a valid Google Maps API key to retrieve elevation data.

```bash
docker run -p 80:80 \
    -e MAPS_API_KEY=your_google_maps_api_key \
    thrnz/earthvr-custom-tours
```

For more advanced configuration, you can use Docker Compose:

```bash
# Clone the repository
git clone https://github.com/ElderlyAR/earthvr-custom-tours.git
cd earthvr-custom-tours

# Create .env file
cp .env.example .env

# Edit .env file and add your Google Maps API key
# MAPS_API_KEY=your_google_maps_api_key

# Start the application
docker-compose up -d
```

### Manual Installation

#### Requirements

- PHP 8.2 or higher
- Composer
- Node.js 20 or higher
- npm
- Redis (optional, for caching)

#### Installation Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/ElderlyAR/earthvr-custom-tours.git
   cd earthvr-custom-tours
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Build frontend assets:
   ```bash
   npm run build
   ```

5. Create environment file:
   ```bash
   cp .env.example .env
   ```

6. Generate application key:
   ```bash
   php artisan key:generate
   ```

7. Configure your environment variables in the `.env` file, including your Google Maps API key.

8. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

### Creating a Tour

1. In Google Earth VR, save locations by pressing the 'star' button on the globe controller.
2. Locate the saved JPG files in your "%Username%/Pictures/Google Earth VR" folder.
3. Upload these JPG files to the application.
4. Configure tour settings:
   - Duration at each location
   - Starting and ending time of day
   - Tour name
5. Click "Generate Tour" to download the `earthVR.textpb` file.
6. Create a folder in your Google Earth VR installation directory:
   ```
   SteamApps/Common/EarthVR/assets/content/tours/your_tour_name
   ```
7. Place the downloaded file in this folder.
8. Launch Google Earth VR and find your tour in the menu.

### Adding Audio

- **Background Audio**: Place an .ogg file named 'bgaudio1.ogg' in the same folder as earthVR.textpb.
- **Location-Specific Audio**: Place a DESTNAME.ogg file in the same folder, where DESTNAME is the name of the corresponding JPG file.

## API Documentation

The application provides a simple API for programmatic tour generation:

### Generate Tour

```
POST /api/tours/generate
```

**Parameters:**
- `destinations[]`: Array of JPG files
- `delay`: Duration at each location (seconds)
- `init_time`: Starting hour (0-23)
- `end_time`: Ending hour (0-23)
- `tourname`: Name of the tour

**Response:**
- 200 OK: Returns the tour file
- 400 Bad Request: Invalid parameters
- 500 Internal Server Error: Tour generation failed

## Development

### Technology Stack

- **Backend**: Laravel 11, PHP 8.3
- **Frontend**: Tailwind CSS, Alpine.js
- **Build Tools**: Vite
- **Containerization**: Docker, Docker Compose
- **CI/CD**: GitHub Actions
- **Deployment**: Google Cloud Run, App Engine

### Development Workflow

1. Fork and clone the repository
2. Install dependencies
3. Create a feature branch
4. Make your changes
5. Run tests
6. Submit a pull request

### Testing

```bash
# Run PHP tests
php artisan test

# Run JavaScript tests
npm test

# Run code style checks
composer lint

# Run static analysis
composer analyse
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgements

- [Google Earth VR](https://arvr.google.com/earth/)
- [Laravel](https://laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)
- [FilePond](https://pqina.nl/filepond/)
- [Google Maps API](https://developers.google.com/maps)

## Contact

Project Link: [https://github.com/thrnz/earthvr-custom-tours](https://github.com/thrnz/earthvr-custom-tours)
