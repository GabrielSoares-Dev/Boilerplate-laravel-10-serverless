import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['./src/Infra/Resources/css/app.css', './src/Infra/Resources/js/app.js'],
            refresh: true,
        }),
    ],
});
