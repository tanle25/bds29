<?php

namespace App\Console\Commands;

use App\Http\Controllers\CompressImageController;
use Illuminate\Console\Command;

class ConvertImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:convert';

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
        $task = new CompressImageController();

        $task->compressImage();
    }
}
