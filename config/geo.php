<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    | Used in llms.txt, Organization schema, and AI feed metadata.
    */
    'site_name'        => env('GEO_SITE_NAME', env('APP_NAME')),
    'site_description' => env('GEO_SITE_DESCRIPTION', ''),
    'site_url'         => env('GEO_SITE_URL', env('APP_URL')),

    /*
    |--------------------------------------------------------------------------
    | llms.txt Configuration
    |--------------------------------------------------------------------------
    | The llms.txt file is to AI crawlers what robots.txt is to web crawlers.
    | See: https://llmstxt.org
    */
    'llms_txt' => [
        'enabled'       => true,
        'max_products'  => 500,
        'cache_ttl'     => 3600,    // seconds
        'route'         => '/llms.txt',
        'full_route'    => '/llms-full.txt',   // extended version
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema / JSON-LD
    |--------------------------------------------------------------------------
    */
    'schema' => [
        'auto_inject'      => true,     // inject via middleware on every response
        'include_reviews'  => true,
        'include_faq'      => true,
        'include_breadcrumb' => true,
        'include_organization' => true, // inject org schema on every page
    ],

    /*
    |--------------------------------------------------------------------------
    | GEO Scoring Thresholds
    |--------------------------------------------------------------------------
    */
    'scoring' => [
        'min_description_words'  => 150,
        'min_reviews_for_signal' => 10,
        'min_rating_for_signal'  => 4.0,
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Product Feed
    |--------------------------------------------------------------------------
    */
    'feed' => [
        'enabled'       => true,
        'route'         => '/ai-product-feed.json',
        'sitemap_route' => '/ai-sitemap.xml',
        'cache_ttl'     => 900,
        'per_page'      => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Citation Engine
    |--------------------------------------------------------------------------
    */
    'citation' => [
        'inject_ratings'        => true,
        'inject_certifications' => true,
        'inject_awards'         => true,
        'inject_stats'          => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    'dashboard' => [
        'enabled'    => true,
        'path'       => env('GEO_DASHBOARD_PATH', '/geo'),

        /*
        | Auth middleware for the dashboard.
        | Set to null or 'none' to disable auth (dev only).
        | Examples: 'auth', 'auth:admin', 'auth:sanctum', 'auth:web'
        */
        'middleware' => env('GEO_DASHBOARD_MIDDLEWARE', 'web'),

        /*
        | Which models to display in the Models page.
        | Each entry: ['model' => 'App\Models\Product', 'label' => 'Products']
        */
        'models' => [
            // ['model' => \App\Models\User::class, 'label' => 'Users'],
            // ['model' => \App\Models\Product::class, 'label' => 'Products'],
        ],
    ],
];
