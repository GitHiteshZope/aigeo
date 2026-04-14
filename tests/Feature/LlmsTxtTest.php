<?php

use Hszope\LaravelAigeo\Tests\TestCase;

uses(TestCase::class);

it('serves llms.txt at the correct route', function () {
    config(['geo.site_name' => 'TestStore', 'geo.llms_txt.enabled' => true]);

    $response = $this->get('/llms.txt');

    $response->assertStatus(200)
             ->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
});

it('serves ai product feed as json', function () {
    $response = $this->get('/ai-product-feed.json');

    $response->assertStatus(200)
             ->assertJsonStructure(['data', 'meta']);
});
