# Vue 3 Native Components (Plan 0004)

This document describes the Vue 3 native components introduced in Plan 0004 as an alternative to the Blade bridge approach.

> **Note:** The Blade bridge (the original approach using `form.blade.php` fetched into a Vue modal) is still fully supported and unchanged. The new Vue native components are additive and optional.

## Overview

The package now includes two Vue 3 Single File Components (SFCs) in the `examples/vue/` demo project:

### DataTable.vue
A server-side rendered data table component that:
- Connects to the existing `/posts-data` AJAX endpoint (the same Yajra DataTables endpoint)
- Supports server-side pagination, searching, and column sorting
- Emits `edit` and `delete` events for CRUD operations
- Uses native `fetch()` API (no extra dependencies)

### FormModal.vue
A modal form component that:
- Handles both Create and Edit operations
- Connects to the existing `/posts` RESTful endpoints (POST for create, PUT for update)
- Resets form state when opened/closed
- Emits `saved` and `close` events

## Demo Page

A new route `/posts-vue-native` renders `IndexVueNative.vue` which combines both components into a working CRUD example.

## Key Benefits Over Blade Bridge

| Aspect | Blade Bridge (Original) | Vue Native (New) |
|--------|------------------------|------------------|
| Form rendering | Fetch Blade view → innerHTML | Native Vue template |
| Reactivity | Alpine.js x-model | Vue v-model |
| Modal | Alpine globalModal | Native Vue component |
| Bundle | Requires Alpine.initTree | No extra init needed |

## Installation

The components are located in:
```
examples/vue/resources/js/Components/
```

To use them in your own Vue/Inertia app, copy:
- `Components/DataTable.vue`
- `Components/FormModal.vue`

And ensure your `jsconfig.json` or `tsconfig.json` has the `@` alias pointing to `resources/js/`.