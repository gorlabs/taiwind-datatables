<?php

namespace Gorlabs\TailwindDatatables;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class TailwindDatatablesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tailwind-datatables');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'gorlabs-tailwind-datatables');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/tailwind-datatables'),
        ], 'tailwind-datatables-views');

        $this->publishes([
            __DIR__.'/../config/gorlabs-tailwind-datatables.php' => config_path('gorlabs-tailwind-datatables.php'),
        ], 'gorlabs-tailwind-datatables-config');

        // YENİ EKLENEN KOD: CSS Dosyasını yayımlama
        $this->publishes([
            __DIR__.'/../resources/css/_utility-colors.css' => resource_path('css/_utility-colors.css'),
            __DIR__.'/../resources/css/datatables-tailwind.css' => resource_path('css/datatables-tailwind.css'),
        ], 'tailwind-datatables-css'); // Bu, CSS dosyasını yayımlamak için yeni bir publish grubu oluşturur.

        // YAJRA DATATABLES HTML YAPILANDIRMASINI OTOMATİK SET ETME
        // Bu kısım, config/gorlabs-tailwind-datatables.php içindeki
        // override_yajra_config anahtarına bağlıdır.
        // Varsayılan: true (mevcut davranış — Yajra'nın script/view yolunu runtime'da override eder)
        // false: kullanıcı kendi config/datatables-html.php ayarlarını kullanabilir.
        if (config('gorlabs-tailwind-datatables.override_yajra_config', true)) {
            Config::set('datatables-html.script', 'tailwind-datatables::datatable.scripts');
            Config::set('datatables-html.view', 'tailwind-datatables::datatable.table');
        }

        // JS-CONFIG BRIDGE: Config değerlerini Blade üzerinden JS'e aktar
        // Bu değerler crud-datatable.js ve post-form.js tarafından okunur.
        $renderOptions = config('gorlabs-tailwind-datatables.render_options', []);
        $defaults = config('gorlabs-tailwind-datatables.defaults', []);

        $jsConfig = [
            'date_format' => $renderOptions['date_format'] ?? 'DD.MM.YYYY HH:mm',
            'text_truncate_length' => $renderOptions['text_truncate_length'] ?? 50,
            'status_badges' => $renderOptions['status_badges'] ?? [
                'published' => ['text' => 'Yayınlandı', 'class' => 'bg-green-500'],
                'draft' => ['text' => 'Taslak', 'class' => 'bg-red-500'],
            ],
            'alerts' => [
                'success' => 'Başarılı!',
                'success_default' => 'İşlem başarıyla tamamlandı!',
                'error' => 'Hata!',
                'network_error' => 'Bir ağ hatası oluştu veya sunucuya ulaşılamadı: ',
            ],
            'locale' => app()->getLocale(),
        ];

        // View composer ile config'i views'a enjekte et
        View::composer(['tailwind-datatables::datatables.table', 'tailwind-datatables::datatables.scripts'], function ($view) use ($jsConfig) {
            $view->with('gorlabsDatatablesConfig', $jsConfig);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/gorlabs-tailwind-datatables.php', 'gorlabs-tailwind-datatables'
        );
    }
}
