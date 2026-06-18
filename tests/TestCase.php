<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Bind default slug parameter for testing route helpers
        $this->afterApplicationCreated(function () {
            $barbershop = \Illuminate\Support\Facades\DB::table('barbershops')->first();
            $slug = $barbershop ? $barbershop->slug : 'arga-barbershop';
            \Illuminate\Support\Facades\URL::defaults(['slug' => $slug]);
        });
    }
}
