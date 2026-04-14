<?php

namespace Hszope\LaravelAigeo\Console;

use Illuminate\Console\Command;
use Hszope\LaravelAigeo\Modules\LlmsTxt\LlmsTxtGenerator;

class GenerateLlmsTxt extends Command
{
    protected $signature   = 'geo:llms-txt {--full : Generate the full version}';
    protected $description = 'Generate and cache the llms.txt file';

    public function handle(LlmsTxtGenerator $generator): int
    {
        $full = $this->option('full');
        $this->info($full ? 'Generating llms-full.txt...' : 'Generating llms.txt...');
        
        $content = $generator->generate($full);
        $filename = $full ? 'llms-full.txt' : 'llms.txt';
        
        file_put_contents(public_path($filename), $content);
        
        $this->info("Successfully generated public/{$filename}");
        
        return self::SUCCESS;
    }
}
