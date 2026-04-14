<?php

namespace Hszope\LaravelAigeo\View\Directives;

use Illuminate\View\Compilers\BladeCompiler;

class GeoDirectives
{
    public static function register(BladeCompiler $blade): void
    {
        $blade->directive('geo_schema', function ($expression) {
            return "<?php echo app('geo.schema')->product($expression)->render(); ?>";
        });

        $blade->directive('geo_faq', function ($expression) {
            return "<?php echo app('geo.schema')->withFAQ($expression)->render(); ?>";
        });
    }
}
