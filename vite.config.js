import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import dotenv from 'dotenv';

dotenv.config();

export default defineConfig({
    server: {
        host: process.env.APP_URL || '0.0.0.0',  // menggunakan APP_URL dari .env jika ada
    },

    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],

    base: '/'
});
