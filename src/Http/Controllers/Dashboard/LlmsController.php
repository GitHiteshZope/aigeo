<?php

namespace Hszope\LaravelAigeo\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Hszope\LaravelAigeo\Modules\LlmsTxt\LlmsTxtGenerator;
use Illuminate\Support\Facades\Artisan;

class LlmsController extends Controller
{
    public function index(LlmsTxtGenerator $generator)
    {
        return view('geo::dashboard.llms', [
            'content' => $generator->generate(false),
            'full_content' => $generator->generate(true),
        ]);
    }

    public function regenerate()
    {
        Artisan::call('geo:llms-txt');
        Artisan::call('geo:llms-txt', ['--full' => true]);
        return back()->with('success', 'llms.txt regenerated successfully.');
    }
}
