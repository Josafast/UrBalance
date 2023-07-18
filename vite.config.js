import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 
            'resources/js/app.js',
            'resources/js/glide.js',
            'resources/js/forms.js',
            'node_modules/@glidejs/glide/dist/css/glide.core.min.css',
            'node_modules/@glidejs/glide/dist/css/glide.theme.min.css'],
            refresh: true,
        }),
    ],
});
