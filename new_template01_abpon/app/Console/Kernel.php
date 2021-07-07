<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\refreshPromotion::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) // ทุกๆ 1 ชั่วโมง
    {
        // $schedule->command('cron:refreshPromotion')->hourly()->when(function(){
        //     return true;
        // });
        $schedule->call(function () {
            app('App\Http\Controllers\PromotionController')->refreshPromotionPrice();
        })->everyMinute()->runInBackground();

        $schedule->call(function () {
            app('App\Http\Controllers\UsersController')->setUsersOffline();
        })->everyThirtyMinutes()->runInBackground();
    }
    
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
// php artisan schedule:run
// php artisan cron:refreshPromotion