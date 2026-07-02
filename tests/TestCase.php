<?php

namespace Gorlabs\TailwindDatatables\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Gorlabs\TailwindDatatables\TailwindDatatablesServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            TailwindDatatablesServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:testkey1234567890abcdefghijklmnopqrstuvwxyz1234567890==');
    }
}