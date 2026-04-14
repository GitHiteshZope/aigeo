<?php

namespace Hszope\LaravelAigeo\Console;

use Illuminate\Console\Command;
use Hszope\LaravelAigeo\Modules\Feed\ProductFeedGenerator;

class GenerateProductFeed extends Command
{
    protected $signature   = 'geo:feed';
    protected $description = 'Generate the AI product feed';

    public function handle(ProductFeedGenerator $generator): int
    {
        $this->info('Generating AI product feed...');
        
        $feed = $generator->generate();
        file_put_contents(public_path(config('geo.feed.route')), json_encode($feed, JSON_PRETTY_PRINT));
        
        $this->info('Successfully generated product feed.');
        
        return self::SUCCESS;
    }
}
