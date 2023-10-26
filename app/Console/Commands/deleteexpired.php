<?php

namespace App\Console\Commands;

use App\Models\section;
use Illuminate\Console\Command;

class deleteexpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:deleteexpired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expiry (delete table => delete basket) every expiration date automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admins = section::where('deleted_at', '>', date('Y-m-d'))->get();
        foreach($admins as $admin){
            $admin->delete();
        }
    }
}
