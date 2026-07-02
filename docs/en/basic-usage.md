# Basic Usage and Configuration

## Installation

```bash
composer require gorlabs/tailwind-datatables
```

## Configuration

Publish the configuration file to modify the package's default settings:

```bash
php artisan vendor:publish --tag=gorlabs-tailwind-datatables-config
```

This command copies the `config/gorlabs-tailwind-datatables.php` file to your project.

### Available Configuration Options

#### `override_yajra_config` (boolean, default: `true`)

Controls whether the package overrides Yajra DataTables HTML configuration at runtime.

- **`true`** (default): The package automatically sets `datatables-html.script` and `datatables-html.view` to use its own Blade views. This is the recommended setting for new projects.
- **`false`**: The package does NOT override Yajra's configuration. You can set your own values in `config/datatables-html.php`.

> **Warning:** When set to `false`, the Blade views may not render as expected unless you manually configure the corresponding `config/datatables-html.php` keys.

#### Other Options

See the published `config/gorlabs-tailwind-datatables.php` file for full documentation of all available options including `defaults`, `views`, `assets`, `render_options`, and `theme_colors`.