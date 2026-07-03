# React (Inertia) Native Components (Plan 0006)

This document describes the React native components introduced in Plan 0006 as an alternative to the Blade bridge approach.

> **Note:** The Blade bridge (the original approach using `form.blade.php` with Alpine.js) is still fully supported and unchanged. The new React native components are additive and optional.

## Overview

The package now includes two React JSX components in the `examples/react/` demo project:

### DataTable.jsx
A server-side rendered data table component that:
- Connects to the existing `/posts-data` AJAX endpoint (the same Yajra DataTables endpoint)
- Supports server-side pagination, searching, and column sorting
- Accepts `onEdit` and `onDelete` callbacks for CRUD operations
- Uses native `fetch()` API (no extra dependencies)
- Listens for `datatable-reload` custom event to refresh data after CRUD

### FormModal.jsx
A modal form component that:
- Handles both Create and Edit operations via `post` prop (`null` = create, object = edit)
- Connects to the existing `/posts` RESTful endpoints (`POST` for create, `PUT` for update)
- Tracks per-field validation errors and displays them under each input
- Accepts `show`, `post`, `onClose`, and `onSaved` props

## Demo Page

A new route `/posts-react-native` renders `IndexReactNative.jsx` which combines both components into a working CRUD example.

## Key Benefits Over Blade Bridge

| Aspect | Blade Bridge (Original) | React Native (New) |
|--------|------------------------|---------------------|
| Form rendering | Fetch Blade view → innerHTML | Native JSX template |
| Reactivity | Alpine.js x-model | React useState |
| Modal | Alpine globalModal | Native React component |
| Bundle | Requires Alpine.initTree | No extra init needed |

## Installation

The components are located in:
```
examples/react/resources/js/Components/
```

To use them in your own React/Inertia app, copy:
- `Components/DataTable.jsx`
- `Components/FormModal.jsx`
- `Components/FormModal.jsx` requires `prop-types` (run `npm install prop-types`)

### Route Setup

Add the following routes to your `routes/web.php`:

```php
Route::resource('posts', \App\Http\Controllers\PostController::class);
Route::get('/posts-react-native', [\App\Http\Controllers\PostController::class, 'reactNative'])->name('posts.react-native');
Route::get('/posts-data', [\App\Http\Controllers\PostController::class, 'ajaxData'])->name('posts.data');
```

Then add the `reactNative()` method to `PostController.php` (see the example project for reference).

### CSRF Token

The components use `document.querySelector('meta[name="csrf-token"]')` to retrieve the CSRF token for mutations. Make sure your layout (`resources/views/app.blade.php`) includes this meta tag:

```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

> **⚠️ Important:** Some Inertia starter kits (Breeze React included) do NOT include this meta tag by default. If fetch requests return a 419 (Page Expired) error, check that this tag is present in your `<head>`.

### Global Library Dependencies

Unlike the Vue or Livewire native components, the React Blade bridge demo page (`Index.jsx`) relies on several global libraries:
- **jQuery** and **DataTables** — for the original Blade bridge table initialization
- **Alpine.js** — for the original Blade bridge modal
- **SweetAlert2** — for delete confirmations
- **dayjs, JSZip, pdfMake** — for DataTables export buttons

These libraries must be imported and assigned to `window` in your `app.jsx` **before** the Inertia app is created (see the example project's `app.jsx` for the exact import block).

> **⚠️ Important:** The React native components (`DataTable.jsx` + `FormModal.jsx` + `IndexReactNative.jsx`) do NOT require these global libraries. They use native `fetch()` and React state only. The global libraries are only needed if you are also running the Blade bridge page (`Index.jsx`) alongside the React native pages.

### Vite 8 / Rolldown Resolution

If you are using Vite 8+ with Rolldown (the default in newer Laravel Breeze React scaffolds), symlinked vendor packages (`vendor/gorlabs/tailwind-datatables` via path repository) may have resolution issues with packages like `jQuery`, `dayjs`, or `alpinejs`. If you encounter build errors like `Rolldown failed to resolve import "dayjs"`, add explicit aliases in your `vite.config.js`:

```javascript
import path from 'path';

export default defineConfig({
    // ... other config
    resolve: {
        alias: {
            'dayjs': path.resolve(__dirname, 'node_modules/dayjs'),
            'jquery': path.resolve(__dirname, 'node_modules/jquery'),
            'alpinejs': path.resolve(__dirname, 'node_modules/alpinejs'),
            // add other packages as needed
        },
    },
});
```

## Comparison: Vue vs Livewire vs React Native Components

| Feature | Vue Native | Livewire Native | React Native |
|---------|-----------|-----------------|--------------|
| Framework | Vue 3 (Composition API + TypeScript) | Livewire 3 (PHP + Blade) | React 18 (JSX + Hooks) |
| Data fetching | `fetch()` + URLSearchParams | Livewire `WithPagination` | `fetch()` + URLSearchParams |
| Form handling | `v-model` + `watch` | Livewire `Form Object` | `useState` + `useEffect` |
| Modal | Native Vue `<Teleport>` | Livewire `wire:model` | Controlled via `show` prop |
| Validation | per-field errors state | Livewire `$errors` | per-field errors state |
| Server-side | Yajra DataTables | Livewire `sortBy()` + paginate | Yajra DataTables |
| Extra deps | None (native fetch) | None (Livewire built-in) | `prop-types` |