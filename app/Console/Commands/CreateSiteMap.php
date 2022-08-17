<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\RealtyPost;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return 0;
        $sitemap = App::make("sitemap");
        $sitemap->add(URL::to('/'),Carbon::now(),'1.0','daily');

        $projects = Project::whereStatus(1)->orderBy('created_at', 'desc')->get();
        $realties = RealtyPost::whereStatus(3)->orderBy('created_at', 'desc')->get();
        foreach ($projects as $project) {
            # code...
            $sitemap->add(URL::to('du-an',$project->slug),Carbon::now(),'1.0','daily');
        }
        foreach ($realties as $relty) {
            # code...
            $sitemap->add(URL::to('bat-dong-san',$relty->slug),Carbon::now(),'1.0','daily');
        }
        $sitemap->store('xml', 'sitemap');
    }
}
