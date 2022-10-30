<?php

namespace App\Console\Commands;

use App\Http\Controllers\SyncController;
use Illuminate\Console\Command;

class SyncData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:data {mode=recent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data from School MIS with {mode=recent || all}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mode = $this->argument('mode');
        
        $data = (new SyncController)->syncAll( $mode );
            
        $this->info( $data['message'] . ' proceed successfully with mode ' . $mode );

        return Command::SUCCESS;
    }
}
