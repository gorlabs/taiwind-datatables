import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.jsx',
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            'dayjs': path.resolve(__dirname, 'node_modules/dayjs'),
            'jquery': path.resolve(__dirname, 'node_modules/jquery'),
            'alpinejs': path.resolve(__dirname, 'node_modules/alpinejs'),
            'sweetalert2': path.resolve(__dirname, 'node_modules/sweetalert2'),
            'jszip': path.resolve(__dirname, 'node_modules/jszip'),
            'pdfmake': path.resolve(__dirname, 'node_modules/pdfmake'),
            'datatables.net': path.resolve(__dirname, 'node_modules/datatables.net'),
            'datatables.net-buttons': path.resolve(__dirname, 'node_modules/datatables.net-buttons'),
            'datatables.net-responsive': path.resolve(__dirname, 'node_modules/datatables.net-responsive'),
        },
    },
});
