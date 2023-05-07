<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Artisan;

class Clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:all';

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
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('config:clear');
        $this->info('Config cleared successfully');

        Artisan::call('view:clear');
        $this->info('Views cleared successfully');

        Artisan::call('cache:clear');
        $this->info('Cache cleared successfully');

        Artisan::call('route:clear');
        $this->info('Route cleared successfully');
    }
}
