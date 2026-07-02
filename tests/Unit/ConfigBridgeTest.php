<?php

namespace Gorlabs\TailwindDatatables\Tests\Unit;

use Gorlabs\TailwindDatatables\Tests\TestCase;
use Illuminate\Support\Facades\View;

class ConfigBridgeTest extends TestCase
{
    /** @test */
    public function scripts_blade_renders_gorlabs_datatables_config_with_correct_keys()
    {
        $rendered = View::make('tailwind-datatables::datatables.scripts')->render();

        // window.GorlabsDatatables.config objesinin render edildiğini doğrula
        $this->assertStringContainsString('window.GorlabsDatatables.config', $rendered,
            'scripts.blade.php should render window.GorlabsDatatables.config');

        // date_format anahtarı olmalı
        $this->assertStringContainsString('date_format', $rendered,
            'Config bridge should contain date_format key');

        // status_badges anahtarı olmalı
        $this->assertStringContainsString('status_badges', $rendered,
            'Config bridge should contain status_badges key');

        // published badge text olmalı (JSON encoding ile)
        $this->assertStringContainsString('Yay\u0131nland\u0131', $rendered,
            'Config bridge should contain default published badge text (JSON encoded)');
        $this->assertStringContainsString('Taslak', $rendered,
            'Config bridge should contain default draft badge text');

        // alerts anahtarı olmalı
        $this->assertStringContainsString('"alerts"', $rendered,
            'Config bridge should contain alerts key');
        $this->assertStringContainsString('Ba\u015far\u0131l\u0131!', $rendered,
            'Config bridge should contain default alert success text (JSON encoded)');
        $this->assertStringContainsString('Hata!', $rendered,
            'Config bridge should contain default alert error text');

        // locale anahtarı olmalı
        $this->assertStringContainsString('"locale"', $rendered,
            'Config bridge should contain locale key');
    }

    /** @test */
    public function form_blade_uses_lang_instead_of_hardcoded_text()
    {
        // STATIC SOURCE SCAN — View::render __() çağrılarını çözer,
        // bu yüzden ham dosya içeriğini okuyoruz.
        $source = file_get_contents(__DIR__.'/../../resources/views/datatables/form.blade.php');

        // Hardcoded Türkçe metinler OLMAMALI (direkt HTML içinde yazılı)
        $this->assertStringNotContainsString('>Başlık<', $source,
            'form.blade.php source should NOT contain hardcoded ">Başlık<" — should use __()');
        $this->assertStringNotContainsString('>İçerik<', $source,
            'form.blade.php source should NOT contain hardcoded ">İçerik<" — should use __()');
        $this->assertStringNotContainsString('>Yayınlandı mı?<', $source,
            'form.blade.php source should NOT contain hardcoded ">Yayınlandı mı?<" — should use __()');
        $this->assertStringNotContainsString('>İptal<', $source,
            'form.blade.php source should NOT contain hardcoded ">İptal<" — should use __()');
        $this->assertStringNotContainsString('>Kaydet<', $source,
            'form.blade.php source should NOT contain hardcoded ">Kaydet<" — should use __()');
        $this->assertStringNotContainsString('>Kaydediliyor...<', $source,
            'form.blade.php source should NOT contain hardcoded ">Kaydediliyor...<" — should use __()');

        // __() çağrıları olmalı
        $this->assertStringContainsString("__('gorlabs-tailwind-datatables::messages.form.title')", $source,
            'form.blade.php source should contain __() call for form.title');
        $this->assertStringContainsString("__('gorlabs-tailwind-datatables::messages.form.content')", $source,
            'form.blade.php source should contain __() call for form.content');
        $this->assertStringContainsString("__('gorlabs-tailwind-datatables::messages.form.cancel')", $source,
            'form.blade.php source should contain __() call for form.cancel');
        $this->assertStringContainsString("__('gorlabs-tailwind-datatables::messages.form.save')", $source,
            'form.blade.php source should contain __() call for form.save');
    }

    /** @test */
    public function lang_files_have_matching_keys()
    {
        $tr = json_decode(file_get_contents(__DIR__.'/../../resources/lang/tr.json'), true);
        $en = json_decode(file_get_contents(__DIR__.'/../../resources/lang/en.json'), true);

        $this->assertNotNull($tr, 'tr.json should be valid JSON');
        $this->assertNotNull($en, 'en.json should be valid JSON');

        // Her iki dosyada aynı anahtarlar olmalı
        $this->assertEquals(array_keys($tr), array_keys($en),
            'tr.json and en.json should have identical keys');

        // Anahtarlar form.blade.php'de kullanılanlarla eşleşmeli
        $expectedKeys = [
            'form.title',
            'form.content',
            'form.is_published',
            'form.published_at',
            'form.cancel',
            'form.save',
            'form.saving',
            'alert.success',
            'alert.success_default',
            'alert.error',
            'badge.published',
            'badge.draft',
        ];

        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $tr, "tr.json should have key '$key'");
            $this->assertArrayHasKey($key, $en, "en.json should have key '$key'");
        }
    }
}