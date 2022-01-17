<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FirebaseRealtimeDatabase;

class FirebaseCleaner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:cleaner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove cancelled orders';

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
        $FirebaseRealtimeDatabase = new FirebaseRealtimeDatabase();
        $FirebaseRealtimeDatabase->clean_data("orders");
    }
}
