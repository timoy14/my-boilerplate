<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Purchase;
use App\Model\Setting;
use Illuminate\Support\Carbon;

class OrderAutoCancel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel Order';

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
        $Setting = Setting::find(1);
        $purchases = Purchase::where("status","order_received")
                                ->where('created_at', '<', Carbon::now()->subMinutes(isset($Setting->cancellation_time_limit) ? $Setting->cancellation_time_limit : 10))
                                ->update(
                                        [
                                            "status"=>"cancelled",
                                            "status_notes"=>"(" . Carbon::now() . ") order has been cancelled due to the pharmacy didn't accept the order. %%"
                                        ]);
        return 1;
    }
}
