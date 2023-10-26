<?php

namespace App\Console\Commands;

use App\Models\product;
use App\Models\section;
use Illuminate\Console\Command;

class deleteexpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:expired';

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
        section::where('deleted_at', '<=', now()->subDays( 30 ))->forcedelete();
        product::where('deleted_at', '<=', now()->subDays( 30 ))->forcedelete();
    }
}
