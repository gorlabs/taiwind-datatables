<?php

namespace Gorlabs\TailwindDatatables\Tests\Unit;

use Gorlabs\TailwindDatatables\Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

class ServiceProviderTest extends TestCase
{
    /** @test */
    public function view_namespace_is_registered()
    {
        $exists = View::exists('tailwind-datatables::datatables.table');
        $this->assertTrue($exists, 'tailwind-datatables::datatables.table view should be registered');
    }

    /** @test */
    public function scripts_view_is_registered()
    {
        $exists = View::exists('tailwind-datatables::datatables.scripts');
        $this->assertTrue($exists, 'tailwind-datatables::datatables.scripts view should be registered');
    }

    /** @test */
    public function form_view_is_registered()
    {
        $exists = View::exists('tailwind-datatables::datatables.form');
        $this->assertTrue($exists, 'tailwind-datatables::datatables.form view should be registered');
    }

    /** @test */
    public function config_is_mergeable()
    {
        $vendor = config('gorlabs-tailwind-datatables.vendor');
        $this->assertEquals('gorlabs', $vendor);
    }

    /** @test */
    public function config_publish_tag_exists()
    {
        $publishGroups = \Illuminate\Support\ServiceProvider::$publishGroups;

        $this->assertArrayHasKey('gorlabs-tailwind-datatables-config', $publishGroups,
            'Config publish tag gorlabs-tailwind-datatables-config should exist');
        $this->assertArrayHasKey('tailwind-datatables-views', $publishGroups,
            'View publish tag tailwind-datatables-views should exist');
        $this->assertArrayHasKey('tailwind-datatables-css', $publishGroups,
            'CSS publish tag tailwind-datatables-css should exist');
    }

    /** @test */
    public function override_yajra_config_default_is_true()
    {
        // Config'de varsayılan değer true olmalı (mevcut davranış korunur)
        $this->assertTrue(config('gorlabs-tailwind-datatables.override_yajra_config'),
            'override_yajra_config should default to true');
    }

    /** @test */
    public function datatables_html_config_is_overridden_at_runtime_when_enabled()
    {
        // CHARACTERIZATION TEST (override_yajra_config: true — varsayılan)
        // ServiceProvider boot() içinde Config::set('datatables-html.script', ...)
        // ve Config::set('datatables-html.view', ...) çağrılıyor.
        // Bu test, bu override'ın gerçekten çalıştığını doğrular.

        $script = Config::get('datatables-html.script');
        $view = Config::get('datatables-html.view');

        $this->assertEquals('tailwind-datatables::datatable.scripts', $script,
            'Config::set override should set datatables-html.script to tailwind-datatables::datatable.scripts');
        $this->assertEquals('tailwind-datatables::datatable.table', $view,
            'Config::set override should set datatables-html.view to tailwind-datatables::datatable.table');
    }

    /** @test */
    public function datatables_html_config_override_overwrites_user_config_when_enabled()
    {
        // CHARACTERIZATION TEST: override_yajra_config:true iken kullanıcı config'i ezilir
        Config::set('datatables-html.script', 'user-defined::scripts');
        Config::set('datatables-html.view', 'user-defined::table');

        $this->artisan('config:clear');
        $provider = new \Gorlabs\TailwindDatatables\TailwindDatatablesServiceProvider($this->app);
        $provider->boot();

        $this->assertEquals('tailwind-datatables::datatable.scripts', Config::get('datatables-html.script'),
            'Even if user sets datatables-html.script, ServiceProvider boot() should override it when override_yajra_config is true');
        $this->assertEquals('tailwind-datatables::datatable.table', Config::get('datatables-html.view'),
            'Even if user sets datatables-html.view, ServiceProvider boot() should override it when override_yajra_config is true');
    }

    /** @test */
    public function datatables_html_config_is_not_overridden_when_disabled()
    {
        // override_yajra_config:false iken override çalışmamalı
        // Kullanıcı kendi config değerini koruyabilmeli
        // Not: config:clear mergeConfigFrom'u sıfırlar, bu yüzden önce merge et,
        // sonra override'ı false yap, sonra boot et
        $this->artisan('config:clear');

        // ServiceProvider'ı register et (mergeConfigFrom çalışır)
        $provider = new \Gorlabs\TailwindDatatables\TailwindDatatablesServiceProvider($this->app);
        $provider->register();

        // override'ı false yap
        Config::set('gorlabs-tailwind-datatables.override_yajra_config', false);
        // Kullanıcı kendi değerlerini ayarlasın
        Config::set('datatables-html.script', 'user-defined::scripts');
        Config::set('datatables-html.view', 'user-defined::table');

        // boot et — override çalışmamalı
        $provider->boot();

        $this->assertEquals('user-defined::scripts', Config::get('datatables-html.script'),
            'When override_yajra_config is false, user-defined datatables-html.script should be preserved');
        $this->assertEquals('user-defined::table', Config::get('datatables-html.view'),
            'When override_yajra_config is false, user-defined datatables-html.view should be preserved');
    }
}