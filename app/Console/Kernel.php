<?php

namespace App\Console;
use App\Console\Commands\MyScheduledCommand;

use App\Models\TB_Logs\Log_ContractsCon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        Commands\InsertDataCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->call(function () {
        //    $data =  new Log_ContractsCon;
        //    $data->details = 'test';
        //    $data->save();
        // })->everySecond();

        $schedule->call(function () {
            // โค้ดที่ต้องการให้ทำทุกนาที
        })->everyMinute();

        $schedule->command('my:scheduled-command')->everyMinute()->runInBackground();
        $schedule->command('loginsert')->everyMinute();

    }

    // protected function commands()
    // {
    //     $this->load(__DIR__.'/Commands');

    //     require base_path('routes/console.php');
    // }
}
