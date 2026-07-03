import '../css/app.css';
import './bootstrap';

// ********************************************************************
// * DataTables ve İlgili Kütüphaneler (SADECE GLOBAL İHTİYAÇLAR)     *
// ********************************************************************

import jQuery from 'jquery';
window.jQuery = jQuery;
window.$ = jQuery;

import 'datatables.net';
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-buttons/js/buttons.print.js';
import 'datatables.net-buttons/js/buttons.colVis.js';
import 'datatables.net-responsive';

import JSZip from 'jszip';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
window.JSZip = JSZip;
window.pdfMake = pdfMake;
window.pdfMake.vfs = pdfFonts.vfs;

import Swal from 'sweetalert2';
window.Swal = Swal;

import dayjs from 'dayjs';
window.dayjs = dayjs;

import Alpine from 'alpinejs';

import { registerGorlabsDatatablesAlpineComponents } from '../../vendor/gorlabs/tailwind-datatables/resources/js/crud-datatable';

// ********************************************************************
// * Mevcut Inertia.js ve React başlatma kodları                      *
// ********************************************************************
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx'),
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

registerGorlabsDatatablesAlpineComponents(Alpine);
Alpine.start();
