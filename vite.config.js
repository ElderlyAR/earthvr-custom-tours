import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    build: {
        sourcemap: process.env.NODE_ENV === 'development',
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: [
                        'alpinejs',
                        'axios',
                        'filepond',
                        'mapbox-gl',
                    ],
                },
            },
        },
    },
});