<?php

namespace App\Console\Commands;

use App\Model\Notification;
use App\Model\Service;
use App\Model\Subscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiredOfferedServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:offer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Expired Offered Services Everyday';

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
        $todayDate = Carbon::today()->toDateString();

        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            if ($todayDate > $subscriber->expired_at) {

                $notify = new Notification();
                $notify->title = "subscription  expired";
                $notify->user_id = $subscriber->user_id;
                $notify->message = "your subscription has benn expired";
                $notify->save();
                $subscriber = Subscriber::find($subscriber->id);
                $subscriber->delete();
            }
        }
        $services = Service::all();
        foreach ($services as $service) {
            if (isset($service->offer_date_start) && isset($service->offer_date_start)) {
                if ($todayDate >= $service->offer_date_start && $todayDate <= $service->offer_date_end && $service->offer == 0) {

                    $data = Service::find($service->id);
                    $data->offer = 1;
                    $data->save();

                    $notify = new Notification();
                    $notify->title = "offer strted";
                    $notify->branch_id = $data->id;
                    $notify->message = "the offer " . $data->name . "has been started";
                    $notify->save();

                } elseif ($todayDate > $service->offer_date_end && $service->offer == 1) {

                    $data = Service::find($service->id);
                    $data->offer = 0;
                    $data->save();

                    $notify = new Notification();
                    $notify->title = "offer expired";
                    $notify->branch_id = $data->id;
                    $notify->message = "the offer " . $data->name . "has been expired";
                    $notify->save();
                }
            }
        }
    }

}