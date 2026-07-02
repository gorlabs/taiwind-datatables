<?php

namespace Gorlabs\TailwindDatatables\Tests\Unit;

use Gorlabs\TailwindDatatables\Tests\TestCase;

/**
 * STATIC SOURCE SCAN — does not verify runtime JS behavior.
 *
 * Bu test, Alpine.data('postForm', ...) kaydının JS kaynak dosyalarında
 * sadece 1 kez geçtiğini doğrular (crud-datatable.js içinde).
 * post-form.js'ten kaldırıldığından emin olur.
 *
 * Bu bir "gerçek davranış testi" (behavioral test) değildir, statik
 * kaynak taramasıdır (static source scan). JS çalışma zamanında
 * component'in gerçekten kayıtlı olup olmadığını doğrulamaz.
 * Madde 9 gereği: "gerçek test" iddiası taşımaz, sadece "kaynak kod
 * yapısını doğrular" olarak etiketlenir.
 */
class AlpineRegistrationTest extends TestCase
{
    /** @test */
    public function alpine_postForm_registered_only_once_across_source_files()
    {
        $files = [
            __DIR__.'/../../resources/js/post-form.js',
            __DIR__.'/../../resources/js/crud-datatable.js',
        ];

        $totalCount = 0;

        foreach ($files as $file) {
            $this->assertFileExists($file, "JS source file $file should exist");

            $content = file_get_contents($file);
            $pattern = "/\w+\.data\s*\(\s*'postForm'\s*,/";
            preg_match_all($pattern, $content, $matches);

            $count = count($matches[0]);
            $totalCount += $count;

            // post-form.js'te bu kayıt olmamalı (kaldırıldı)
            if (str_contains($file, 'post-form.js')) {
                $this->assertEquals(0, $count,
                    "post-form.js should NOT contain Alpine.data('postForm', ...). " .
                    "Registration is handled by crud-datatable.js only.");
            }
        }

        // Toplam 1 kayıt olmalı: sadece crud-datatable.js içinde
        $this->assertEquals(1, $totalCount,
            "Alpine.data('postForm', ...) should appear exactly once across all JS source files " .
            "(in crud-datatable.js). Found: $totalCount");
    }
}