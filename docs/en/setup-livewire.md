* [Gorlabs Tailwind Datatable Main Page](../../README.md)
### Laravel Breeze Livewire Projesine gorlabs/tailwind-datatables Paketi Entegrasyon Kılavuzu
This guide details the step-by-step integration of the gorlabs/tailwind-datatables Composer package into an existing Laravel Breeze (Livewire + Blade stack) project. The guide includes critical notes to ensure Tailwind CSS v3.x compatibility.

### Prerequisites
* PHP 8.2 or higher

* Composer

* Node.js and npm/Yarn

* Laravel 12.x


### Project Creation (Laravel Breeze)
Please start your project development with this DataTables-integrated project, as it will resolve many issues from the outset.

Create a New Laravel Project:

```bash
laravel new livewire-example && cd livewire-example && touch resources/js/bootstrap.js &&  composer require laravel/breeze --dev && php artisan breeze:install livewire
```
Continue by selecting Livewire from the available options.
Choose Laravel's built-in authentication.

Select your preference for "Would you like to use Laravel Volt?". Then, choose either Pest or PHPUnit and proceed.
Select your preference for "Would you like to run npm install and npm run build?".

If the installation completes without issues, edit the database options in your .env file.

Prepare Your Database:
Configure your database connection settings in your .env file (e.g., DB_DATABASE=gorlabs_datatable).

### Installing the gorlabs/tailwind-datatables Package

```bash
composer require gorlabs/tailwind-datatables
```
### Publish the Package's Assets and Configurations:
This command copies the package's CSS/JS assets and configuration files into your project.
```bash
 
php artisan vendor:publish --tag=tailwind-datatables-views
php artisan vendor:publish --tag=gorlabs-tailwind-datatables-config 
php artisan vendor:publish --tag=tailwind-datatables-css
```

## Frontend Configuration (Vite, Tailwind CSS, Alpine.js)
### gorlabs-datatable/tailwind.config.js Update (CRITICAL!)
Open your gorlabs-datatable/tailwind.config.js file.

Completely replace the content of the file with the following. This will correctly import the Tailwind Forms plugin and define custom colors.
```js 
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/*.js',
        './resources/css/*.css',
        './vendor/gorlabs/tailwind-datatables/resources/views/**/*.blade.php',
        './vendor/gorlabs/tailwind-datatables/resources/js/**/*.js',
        './vendor/gorlabs/tailwind-datatables/**/*.{html,js,ts,jsx,tsx,vue,css}',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                white: {
                    DEFAULT: 'rgb(var(--color-white) / <alpha-value>)',
                    // ... diğer white tonları ...
                },
                // Her renk için RGB formatında CSS değişkeni referansı
                primary: {
                    DEFAULT: "rgb(var(--color-primary-DEFAULT) / <alpha-value>)",
                    light: "rgb(var(--color-primary-light) / <alpha-value>)",
                    "dark-light": "rgb(var(--color-primary-dark-light) / <alpha-value>)",
                },
                secondary: {
                    DEFAULT: "rgb(var(--color-secondary-DEFAULT) / <alpha-value>)",
                    light: "rgb(var(--color-secondary-light) / <alpha-value>)",
                    "dark-light": "rgb(var(--color-secondary-dark-light) / <alpha-value>)",
                },
                success: {
                    DEFAULT: "rgb(var(--color-success-DEFAULT) / <alpha-value>)",
                    light: "rgb(var(--color-success-light) / <alpha-value>)",
                    "dark-light": "rgb(var(--color-success-dark-light) / <alpha-value>)",
                },
                danger: {
                    DEFAULT: "rgb(var(--color-danger-DEFAULT) / <alpha-value>)",
                    light: "rgb(var(--color-danger-light) / <alpha-value>)",
                    "dark-light": "rgb(var(--color-danger-dark-light) / <alpha-value>)",
                },
                warning: {
                    DEFAULT: "rgb(var(--color-warning-DEFAULT) / <alpha-value>)",
                    light: "rgb(var(--color-warning-light) / <alpha-value>)",
                    "dark-light": "rgb(var(--color-warning-dark-light) / <alpha-value>)",
                },
                info: {
                    DEFAULT: "rgb(var(--color-info-DEFAULT) / <alpha-value>)",
                    light: "rgb(var(--color-info-light) / <alpha-value>)",
                    "dark-light": "rgb(var(--color-info-dark-light) / <alpha-value>)",
                },
                dark: {
                    DEFAULT: "rgb(var(--color-dark-DEFAULT) / <alpha-value>)",
                    light: "rgb(var(--color-dark-light) / <alpha-value>)",
                    "dark-light": "rgb(var(--color-dark-dark-light) / <alpha-value>)",
                },
                black: {
                    DEFAULT: 'rgb(var(--color-black) / <alpha-value>)', // Bu, bg-black'i senin --color-black değişkeninden almasını sağlar
                    // Eğer bg-opacity-50 gibi kullanımların kendi özel black rengin üzerinden olmasını istiyorsan
                    // veya doğrudan black renk paletine kendi değişkenlerini bağlamak istiyorsan:
                    50: 'rgb(var(--color-black-50) / <alpha-value>)', // varsayımsal: --color-black-50 varsa
                    // ... diğer black tonları ...
                },
                // DataTables ile ilişkili özel renkler
                'dt-primary': {
                    DEFAULT: 'rgb(var(--color-dt-primary-DEFAULT) / <alpha-value>)',
                    dark: 'rgb(var(--color-dt-primary-dark) / <alpha-value>)',
                    light: 'rgb(var(--color-dt-primary-light) / <alpha-value>)',
                },
            },
        },
    },

    plugins: [forms],
};


```


### gorlabs-datatable/vite.config.js Update (CRITICAL!)
Open your gorlabs-datatable/vite.config.js file.

Completely replace the content of the file with the following

```js 
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcssPlugin from '@tailwindcss/postcss'; // Burası önemli
import autoprefixer from 'autoprefixer';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        minify: true, //  Minificaiton open
        sourcemap: true, // Hata ayıklama için sourcemap oluştur
    },
    css: {
        postcss: {
            plugins: [
                tailwindcssPlugin, // Ve burası
                autoprefixer,
            ],
        },
    },
    server: {
        cors: true,
    },

});


```

### resources/css/app.css Update 
Open your gorlabs-datatable/resources/css/app.css file and completely replace its content with the following code:
```css
/* Import DataTables Responsive styles here and at the very beginning. */
@import 'tailwindcss';
@tailwind base;
@tailwind components;
@tailwind utilities;


/* CSS variables for DataTables and other custom theme colors. */
:root {
    /* Tailwind CSS Mavi Paleti */
    --color-primary-DEFAULT: 59 130 246;     /* blue-500: #3b82f6 */
    --color-primary-light: 219 234 254;      /* blue-100: #dbeafe */
    --color-primary-dark-light: 191 219 254; /* blue-200: #bfdbfe */

    --color-secondary-DEFAULT: 59 130 246;   /* blue-500: #3b82f6 */
    --color-secondary-light: 219 234 254;    /* blue-100: #dbeafe */
    --color-secondary-dark-light: 191 219 254;/* blue-200: #bfdbfe */

    --color-success-DEFAULT: 59 130 246;     /* blue-500: #3b82f6 */
    --color-success-light: 219 234 254;      /* blue-100: #dbeafe */
    --color-success-dark-light: 191 219 254; /* blue-200: #bfdbfe */

    --color-danger-DEFAULT: 59 130 246;      /* blue-500: #3b82f6 */
    --color-danger-light: 219 234 254;       /* blue-100: #dbeafe */
    --color-danger-dark-light: 191 219 254;  /* blue-200: #bfdbfe */

    --color-warning-DEFAULT: 59 130 246;     /* blue-500: #3b82f6 */
    --color-warning-light: 219 234 254;      /* blue-100: #dbeafe */
    --color-warning-dark-light: 191 219 254; /* blue-200: #bfdbfe */

    --color-info-DEFAULT: 59 130 246;        /* blue-500: #3b82f6 */
    --color-info-light: 219 234 254;         /* blue-100: #dbeafe */
    --color-info-dark-light: 191 219 254;    /* blue-200: #bfdbfe */

    --color-dark-DEFAULT: 59 130 246;        /* blue-500: #3b82f6 */
    --color-dark-light: 219 234 254;         /* blue-100: #dbeafe */
    --color-dark-dark-light: 191 219 254;    /* blue-200: #bfdbfe */

    /* Bu kısımları orijinal bırakıyorum, ancak istiyorsan Tailwind gri/mavi tonlarına dönüştürebiliriz */
    --dt-row-selected: 13, 110, 253;         /* Maviye yakın bir ton */
    --dt-row-selected-text: 255, 255, 255;
    --dt-row-selected-link: 0, 0, 0;
    --dt-row-stripe: 0, 0, 0;
    --dt-row-hover: 0, 0, 0;
    --dt-column-ordering: 0, 0, 0;
    --dt-html-background: 255, 255, 255;

    /* DataTables custom colors (dt-primary) - RGB FORMAT SEPARATED BY SPACES*/
    --color-dt-primary-DEFAULT: 59 130 246; /* blue-500: #3b82f6 */
    --color-dt-primary-dark: 29 78 216;     /* blue-700: #1d4ed8 */
    --color-dt-primary-light: 96 165 250;   /* blue-400: #60a5fa */
}


```
 
### resources/js/app.js Update
Open the gorlabs-datatable/resources/js/app.js file and update its content as follows to include DataTables, Alpine.js, and other necessary libraries:
```js 
import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'datatables.net';
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-buttons/js/buttons.print.js';
import 'datatables.net-buttons/js/buttons.colVis.js';
import 'datatables.net-responsive';
import "datatables.net-responsive-dt/css/responsive.dataTables.css";
import "../../resources/css/datatables-tailwind.css";
import '../../vendor/gorlabs/tailwind-datatables/resources/js/app';

```


```bash
php artisan make:model Post -mfs
```

### Update the app/Models/Post.php Model 

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'published_at',
        'is_published',
        'status',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
}

```


### Update the database/migrations/YYYY_MM_DD_HHMMSS_create_posts_table.php file:
Open the created migration file (its name varies by date) and update the up() method as follows:
```php
<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * Run the migrations.
    */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }  
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }  
};
```




### Update the database/factories/PostFactory.php file:
```php
<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
  */
class PostFactory extends Factory
{
  /**
    * Define the model's default state.
    *
    * @return array<string, mixed>
      */
      public function definition(): array
      {
          return [
              'title' => fake()->sentence(rand(3, 8)),
              'content' => fake()->paragraphs(rand(1, 3), true),
              'published_at' => fake()->optional(0.8)->dateTimeThisYear(), // %80 ihtimalle bir tarih verir
              'is_published' => fake()->boolean(90), // %90 ihtimalle true
              'status' => fake()->randomElement(['draft', 'published', 'archived']),
          ];
      }
 }


```

### Update Your PostSeeder.php File

```php
<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->count(50)->create();
    }
}


```


### Update the database/seeders/DatabaseSeeder.php File:

```php
<?php
namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
    * Seed the application's database.
    */
    public function run(): void
    {
        User::factory(10)->create(); // Varsayılan kullanıcı seeder
        $this->call([
            PostSeeder::class,
        ]);
    }
}

```


### Migrate and Seed the Database:
While in the root directory of your gorlabs-datatable project in the terminal, run this command:

```bash
php artisan migrate:fresh --seed
```
 

### Create app/DataTables/PostsDataTable.php.
  ```bash
php artisan datatable:make PostsDataTable --model=Post
``` 
### Update the content of app/DataTables/PostsDataTable.php.
```php
<?php

namespace App\DataTables;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PostsDataTable extends DataTable
{
    public function query(Post $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('select_checkbox', function(Post $post) {
                return '';
            })
            ->addColumn('actions', function(Post $post) {
                return '';
            })
            ->editColumn('is_published', function(Post $post) {
                return $post->is_published ? 1 : 0;
            })
            ->editColumn('published_at', function(Post $post) {
                return $post->published_at ? $post->published_at->format('Y-m-d H:i:s') : null;
            })
            ->editColumn('title', function(Post $post) {
                $title = $post->title;
                if (strlen($title) > 24) {
                    return substr($title, 0, 24) . ' ...';
                }
                return $title;
            })
            ->editColumn('content', function(Post $post) {
                $content = $post->content;
                if (strlen($content) > 34) {
                    return substr($content, 0, 34) . ' ...';
                }
                return $content;
            });
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('posts-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->select(false)
            ->buttons([
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    public function getColumns(): array
    {
        $columns = [
            Column::computed('select_checkbox')
                ->title('<input type="checkbox" id="select-all-checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">')
                ->exportable(false)
                ->printable(false)
                ->width(10)
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false)
                ->footer('')
                ->responsivePriority(1),
            Column::make('id')->responsivePriority(2),
            Column::make('title')->responsivePriority(3),
            Column::make('content')->responsivePriority(5),
            Column::make('published_at')
                ->title('Published At')
                ->width(150)
                ->responsivePriority(4),
            Column::make('is_published')
                ->title('Published')
                ->width(100)
                ->responsivePriority(4),
            Column::make('status')->responsivePriority(4),
        ];

        $columns[] = Column::computed('actions')
            ->title('ACTIONS')
            ->exportable(false)
            ->printable(false)
            ->width(120)
            ->addClass('text-center')
            ->orderable(false)
            ->searchable(false)
            ->footer('')
            ->responsivePriority(1);

        return $columns;
    }

    protected function filename(): string
    {
        return 'Posts_' . date('YmdHis');
    }
}


```

### Creating app/Http/Controllers/PostController.php
While in the root directory of your gorlabs-datatable project in the terminal, run the following command:

```bash
php artisan make:controller PostController --resource
```

### Update the content of app/Http/Controllers/PostController.php:
```php
<?php

namespace App\Http\Controllers;

use App\DataTables\PostsDataTable;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * DataTable'ı göstermek için ana view'ı döndürür.
     */
    public function index()
    {
        return view('posts.index');
    }

    /**
     * Process datatables ajax request.
     * gorlabs DataTables processes the AJAX request and returns a JSON response.
     *
     * @param PostsDataTable $dataTable An instance of the DataTable class (with dependency injection).
     * @return JsonResponse
     */
    public function ajaxData(PostsDataTable $dataTable)
    {
        Log::info('DataTables AJAX isteği parametreleri:', request()->all());
        // It fetches and processes data using the DataTable's query method.
        return $dataTable->dataTable($dataTable->query(new Post()))->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * Shows the form for creating a new post (to be loaded within a modal).
     */
    public function create()
    {
        // We ensure the form starts empty by sending an empty Post model instance.
// This feeds the initialPost config of the postForm Alpine component.
        return view('tailwind-datatables::datatables.form', ['post' => new Post()]);
    }

    /**
     * Store a newly created resource in storage.  
     * @param Request $request 
     * @return JsonResponse
     */
    public function store(Request $request)
    { 
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            // The 'is_published' field can sometimes be 'on' or null since it comes from a checkbox.
            // Laravel's validation might automatically convert this for boolean,
            // but a manual check can be safer.
            'is_published' => 'nullable|boolean',  
            'published_at' => 'nullable|date',
        ]);

        // If the published_at field comes in empty, set it to null or convert it to a Carbon object.
        $data = $request->except(['published_at']); 
        $data['published_at'] = $request->input('published_at') ? now()->parse($request->input('published_at')) : null;
        $data['is_published'] = (bool) $request->input('is_published', 0); // If the checkbox has a value, true; otherwise, false.

        $post = Post::create($data); 
 
        return response()->json(['success' => 'Post başarıyla oluşturuldu.', 'post' => $post]);
    }

    /**
     * Show the form for editing the specified resource. 
     *
     * @param Post $post 
     * @return \Illuminate\View\View
     */
    public function edit(Post $post)
    {  
        $post->published_at_formatted = $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '';
 
        return view('tailwind-datatables::datatables.form', compact('post'));
    }

    /**
     * Update the specified resource in storage. 
     *
     * @param Request $request 
     * @param Post $post 
     * @return JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        //dd($request->all()); 
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'is_published' => 'boolean|nullable',  
            'published_at' => 'nullable|date',
        ]);

        $data = $request->except(['published_at']); 
        $data['is_published'] = (bool) $request->input('is_published', 0);  
        $data['published_at'] = $request->input('published_at') ? now()->parse($request->input('published_at')) : null;
        //dd($data);
        $post->update($data); 
 
        return response()->json(['success' => 'Post başarıyla güncellendi.', 'post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     * Belirtilen postu veritabanından siler.
     *
     * @param Post $post Silinecek Post modeli.
     * @return JsonResponse
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
            return response()->json(['success' => 'Post başarıyla silindi.']);
        } catch (\Exception $e) { 
            Log::error('Post silinirken hata oluştu: ' . $e->getMessage(), ['post_id' => $post->id]);
            return response()->json(['error' => 'Post silinirken bir hata oluştu.'], 500);
        }
    }
}
```
### Update the content of postcss.config.js.

```js
export default {
    plugins: {
        '@tailwindcss/postcss': {},
        autoprefixer: {},
    },
};
```

### routes/web.php Update
Open your gorlabs-datatable/routes/web.php file and add the following routes:

```php
use App\Http\Controllers\PostController;

require __DIR__.'/auth.php';

// Newly Added Post Routes
Route::resource('posts', PostController::class);
Route::get('posts-data', [PostController::class, 'ajaxData'])->name('posts.data');
```



### Preparing Blade Views
In this step, we'll create the Blade views in your project that will utilize the package's DataTables and modal structure.
```bash
mkdir -p resources/views/posts
touch resources/views/posts/index.blade.php 
```
### Update the content of resources/views/posts/index.blade.php.

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Tailwind DataTables</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gray-100 text-gray-900 min-h-screen p-8">

<div class="container mx-auto" x-data="app()">
    <h1 class="text-3xl font-bold text-center mb-8">Posts List (Gorlabs Tailwind DataTables)</h1>

    @php
    use App\DataTables\PostsDataTable;
    $columns = collect((new PostsDataTable())->getColumns());
    @endphp
    <div class="panel mt-6 overflow-x-auto p-3" x-data='crudDataTable({
            datatableId: "posts-table",
            ajaxUrl: "{{ route('posts.data') }}",
    columns: {!! json_encode($columns->map(function($col) {
    return [
    "data" => $col->name,
    "name" => $col->name,
    "title" => $col->title,
    "orderable" => $col->orderable,
    "searchable" => $col->searchable,
    "className" => $col->className ?? "",
    ];
    })) !!},
    perPage: 10,
    perPageSelect: [10, 25, 50, 100, -1],
    addNewButtonText: "Yeni Post Ekle",
    addEditUrl: "{{ route('posts.create') }}",
    updateUrlPrefix: "{{ url('posts') }}",
    deleteUrlPrefix: "{{ url('posts') }}",
    initialFormState: JSON.parse("{}"),
    responsive: true
    })' x-ref="dataTableContainer">
    {{-- DataTables HTML --}}
    <table id="posts-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" style="width:100%" x-ref="dataTable">
        <thead class="bg-gray-50 dark:bg-gray-800">
        <tr>
            @foreach($columns as $column)
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ $column->title }}
            </th>
            @endforeach
        </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
        {{-- To be populated via DataTables AJAX. --}}
        </tbody>
    </table>
</div>

{{-- Modal Container --}}
<div
    x-data="globalModal()"
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @keydown.escape.window="closeModal"
>
    <div
        class="bg-white dark:bg-gray-900 rounded-lg shadow-lg max-w-4xl w-full max-h-full overflow-auto p-6 relative"
        @click.away="closeModal"
    >
        <h2 class="text-xl font-semibold mb-4" x-text="title"></h2>
        <div id="modal-content"></div>
        <button
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
            @click="closeModal"
            aria-label="Close modal"
        >
            &times;
        </button>
    </div>
</div>
</div>

</body>
</html>
```


# Important: Resolve Tailwind CSS Version Conflict (for npm users)
If you used a starter kit like Laravel Breeze (especially with npx breeze:install livewire) which might install an older version of Tailwind CSS, you might encounter a version conflict with Tailwind CSS v4 required by this package. This often manifests as a [vite:css] [postcss] postcss-import: ... Unknown word "use strict" error during asset compilation.

To fix this:

Open your package.json file.

Locate the devDependencies section.

Remove the line that specifies tailwindcss version 3. It usually looks like this:

```JSON
"tailwindcss": "^3.*.*"
```


(Make sure to keep the tailwindcss entry in your dependencies section, which should be ^4.0.7.)

After making this change, proceed with the npm install and npm run dev/npm run build commands as usual. This ensures that npm correctly installs Tailwind CSS v4.


### Install Packages - Final Touches:



```bash

composer update  
composer dump-autoload
php artisan optimize:clear 
npm cache verify
rm -rf node_modules yarn.lock package-lock.json
rm -rf public/build 
npm install alpinejs @alpinejs/collapse @alpinejs/focus @alpinejs/persist @alpinejs/ui dayjs jquery datatables.net datatables.net-responsive datatables.net-buttons datatables.net-buttons-dt datatables.net-dt datatables.net-responsive-dt jszip pdfmake sweetalert2
npm install --save-dev @tailwindcss/postcss @tailwindcss/vite autoprefixer axios concurrently 
php artisan optimize:clear  
npm run dev 
```
This guide covers the setup and basic file contents for a Laravel + Livewire + Tailwind DataTables project. If you have any questions, please feel free to get in touch.
