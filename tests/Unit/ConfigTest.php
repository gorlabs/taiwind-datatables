<?php

namespace Gorlabs\TailwindDatatables\Tests\Unit;

use Gorlabs\TailwindDatatables\Tests\TestCase;

class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Config'i merge et (register() çağrılır, boot() çağrılır)
        $this->app->boot();
    }

    /** @test */
    public function config_has_vendor_key()
    {
        $this->assertEquals('gorlabs', config('gorlabs-tailwind-datatables.vendor'));
    }

    /** @test */
    public function config_has_author_key()
    {
        $this->assertEquals('Mehmet Çetin Ravullu', config('gorlabs-tailwind-datatables.author'));
    }

    /** @test */
    public function config_has_defaults_dom()
    {
        $dom = config('gorlabs-tailwind-datatables.defaults.dom');
        $this->assertNotNull($dom);
        $this->assertStringContainsString('lfB', $dom);
        $this->assertStringContainsString('rt', $dom);
        $this->assertStringContainsString('ip', $dom);
    }

    /** @test */
    public function config_has_defaults_buttons()
    {
        $buttons = config('gorlabs-tailwind-datatables.defaults.buttons');
        $this->assertIsArray($buttons);
        $this->assertContains('excel', $buttons);
        $this->assertContains('csv', $buttons);
        $this->assertContains('pdf', $buttons);
        $this->assertContains('print', $buttons);
        $this->assertContains('colvis', $buttons);
    }

    /** @test */
    public function config_has_language_url()
    {
        $url = config('gorlabs-tailwind-datatables.defaults.language.url');
        $this->assertNotNull($url);
        // CHARACTERIZATION: Mevcut değer Türkçe CDN
        $this->assertStringContainsString('Turkish.json', $url);
    }

    /** @test */
    public function config_has_responsive_enabled()
    {
        $this->assertTrue(config('gorlabs-tailwind-datatables.defaults.responsive'));
    }

    /** @test */
    public function config_has_paging_type()
    {
        $this->assertEquals('full_numbers', config('gorlabs-tailwind-datatables.defaults.pagingType'));
    }

    /** @test */
    public function config_has_views_table()
    {
        $this->assertEquals(
            'tailwind-datatables::datatable.table',
            config('gorlabs-tailwind-datatables.views.table')
        );
    }

    /** @test */
    public function config_has_views_scripts()
    {
        $this->assertEquals(
            'tailwind-datatables::datatable.scripts',
            config('gorlabs-tailwind-datatables.views.scripts')
        );
    }

    /** @test */
    public function config_has_assets_js()
    {
        $js = config('gorlabs-tailwind-datatables.assets.js');
        $this->assertNotNull($js);
        $this->assertStringContainsString('crud-datatable.js', $js);
    }

    /** @test */
    public function config_has_assets_css()
    {
        $css = config('gorlabs-tailwind-datatables.assets.css');
        $this->assertNotNull($css);
        $this->assertStringContainsString('datatables-tailwind.css', $css);
    }

    /** @test */
    public function config_has_render_options_date_format()
    {
        // CHARACTERIZATION: Mevcut değer Türkçe format (DD.MM.YYYY HH:mm)
        $this->assertEquals(
            'DD.MM.YYYY HH:mm',
            config('gorlabs-tailwind-datatables.render_options.date_format')
        );
    }

    /** @test */
    public function config_has_render_options_text_truncate()
    {
        $this->assertEquals(
            50,
            config('gorlabs-tailwind-datatables.render_options.text_truncate_length')
        );
    }

    /** @test */
    public function config_has_render_options_status_badges()
    {
        $badges = config('gorlabs-tailwind-datatables.render_options.status_badges');
        $this->assertIsArray($badges);
        $this->assertArrayHasKey('published', $badges);
        $this->assertArrayHasKey('draft', $badges);
        // CHARACTERIZATION: Mevcut değerler Türkçe
        $this->assertEquals('Yayınlandı', $badges['published']['text']);
        $this->assertEquals('Taslak', $badges['draft']['text']);
    }

    /** @test */
    public function config_has_theme_colors()
    {
        $theme = config('gorlabs-tailwind-datatables.theme_colors');
        $this->assertIsArray($theme);
        $this->assertArrayHasKey('primary_button', $theme);
        $this->assertArrayHasKey('secondary_button', $theme);
        $this->assertArrayHasKey('pagination_active', $theme);
        $this->assertArrayHasKey('pagination_inactive', $theme);

        $this->assertStringContainsString('indigo', $theme['primary_button']);
        $this->assertStringContainsString('gray', $theme['secondary_button']);
    }
}