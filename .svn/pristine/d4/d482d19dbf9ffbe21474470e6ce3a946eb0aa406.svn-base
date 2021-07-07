<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class refreshPromotion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:refreshPromotion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refresh promotion in prodict price every minute';

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
        $refresh_promotion = app('App\Http\Controllers\PromotionController')->refreshPromotionPrice();
        echo "refresh promotion: " . $refresh_promotion;
        // return dd("hello world");;
    }
}
