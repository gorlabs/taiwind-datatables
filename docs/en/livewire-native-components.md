# Livewire 3 Native Components (Plan 0005)

This document describes the Livewire 3 native components introduced in Plan 0005 as an alternative to the Blade bridge approach.

> **Note:** The Blade bridge (the original approach using `form.blade.php` with Alpine.js) is still fully supported and unchanged. The new Livewire native components are additive and optional.

## Overview

The package now includes a Livewire 3 component in the `examples/livewire/` demo project:

### PostsTable (Full-Stack Livewire Component)

A complete CRUD component built with Livewire 3 that:

- Uses `#[Layout('layouts.posts-demo')]` to render without the Flux sidebar dependency
- Supports **server-side sorting** (click column headers to sort asc/desc)
- Supports **server-side search** (debounced 300ms via `wire:model.live.debounce.300ms`)
- Supports **server-side pagination** via `Livewire\WithPagination` (10 items per page)
- Provides a **full CRUD interface** with Create, Edit, and Delete operations
- Uses a **Livewire Form Object** (`PostForm`) for validation and data handling
- Displays status badges (Published: green / Draft: yellow)
- Matches the visual parity of the Vue native components

### PostForm (Livewire Form Object)

Located at `app/Livewire/Forms/PostForm.php`, this form object:

- Encapsulates the `title`, `content`, `is_published`, and `published_at` fields
- Uses PHP 8 attribute-based validation (`#[Validate]`)
- Provides `store()` and `update()` methods
- Handles the `setPost()` method to populate the form for editing

## Demo Page

A new route `/posts-livewire-native` renders `PostsTable` directly:

```php
Route::get('/posts-livewire-native', \App\Livewire\PostsTable::class)
    ->middleware('auth')
    ->name('posts.livewire-native');
```

## Key Benefits Over Blade Bridge

| Aspect | Blade Bridge (Original) | Livewire Native (New) |
|--------|------------------------|----------------------|
| Form handling | Alpine.js + fetch() | Livewire Form Object |
| Reactivity | Alpine.js x-model | Livewire wire:model |
| Modal | SweetAlert2 / custom JS | Livewire conditional rendering |
| Pagination | Yajra DataTables JS | Livewire WithPagination trait |
| Search | Yajra DataTables API | Livewire wire:model.live |
| Sorting | Yajra DataTables API | Livewire wire:click + query |

## Installation

The component files are located in:

```
examples/livewire/
├── app/Livewire/PostsTable.php
├── app/Livewire/Forms/PostForm.php
├── resources/views/livewire/posts-table.blade.php
└── resources/views/layouts/posts-demo.blade.php
```

### Step 1: Copy the component files

Copy the following files to your Livewire-enabled Laravel project:

- `app/Livewire/PostsTable.php` → `app/Livewire/PostsTable.php`
- `app/Livewire/Forms/PostForm.php` → `app/Livewire/Forms/PostForm.php`
- `resources/views/livewire/posts-table.blade.php` → `resources/views/livewire/posts-table.blade.php`

### Step 2: Create a layout (optional)

If you want to avoid the default Flux sidebar layout, copy `resources/views/layouts/posts-demo.blade.php` to your project's `resources/views/layouts/` directory and reference it in the `#[Layout]` attribute.

If you omit the `#[Layout]` attribute, Livewire will use the default layout defined in `config/livewire.php` (usually `layouts.app`).

### Step 3: Add the route

```php
Route::get('/posts-livewire-native', \App\Livewire\PostsTable::class)
    ->middleware('auth')
    ->name('posts.livewire-native');
```

### Step 4: Ensure the Post model exists

The component uses `App\Models\Post`. Make sure your project has a `Post` model with the following fields:
- `id` (integer, auto-increment)
- `title` (string, 255)
- `content` (text)
- `is_published` (boolean)
- `published_at` (datetime, nullable)

### Step 5: Customization

You can customize the component by:

- Changing `$perPage` in the `paginate()` call
- Modifying the `sortField` and `sortDirection` defaults
- Adding columns to the search query in the `render()` method
- Styling the modal and table classes in the Blade template