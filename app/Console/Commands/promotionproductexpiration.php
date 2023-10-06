<?php

namespace App\Console\Commands;

use App\Models\promotion;
use Illuminate\Console\Command;

class promotionproductexpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'product expiry promotion every end_datetime automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admins = promotion::where('end_time', date('Y-m-d'))->get();
        foreach($admins as $admin){
            $admin->delete();
        }
    }
}
