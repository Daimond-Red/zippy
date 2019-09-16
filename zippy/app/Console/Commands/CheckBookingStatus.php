<?php

namespace App\Console\Commands;

use App\Booking;
use Illuminate\Console\Command;

class CheckBookingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:checkStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will check booking status & will change to expire according to pickup date';

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
     * @return mixed
     */
    public function handle() {
        
        $status = [
            Booking::PENDING,
            Booking::CONFIRMATION_PENDING,
            Booking::VENDOR_CONFIRMATION_PENDING,
        ];

        $collection = Booking::whereIn('status', $status)->whereDate('pickup_date', '<', date('Y-m-d'))->update(['status' => Booking::EXPIRED]);

        $date = date('Y-m-d H:i:s', strtotime('-2 hour'));

        $collectionBeforeTwoHour = \App\Booking::
            whereDate('created_at', '=', date('Y-m-d'))
            ->where('created_at', '<=', $date)
            ->where('status', \App\Booking::PENDING)->get();

        $collectionAfterBidAccepted = \App\Booking::
            where('updated_at', '<=', $date)
            ->where('status', \App\Booking::ALLOCATION_PENDING)->get();

        if($collectionAfterBidAccepted) {
            
            $msg = 'Your booking has expired. Please place a new request.';

            foreach ($collectionAfterBidAccepted as $model) {

                $model->update(['status' => Booking::EXPIRED]);

                sendNotification($model->customer_id, [
                    'booking_id'    => $model->id,
                    'category'      => 'booking_cancel',
                    'body'          => $msg
                ]);
            }
        }

        if($collectionBeforeTwoHour) {
            
            $msg = 'Your booking has expired. Please place a new request.';

            foreach ($collectionBeforeTwoHour as $model) {
                $model->update(['status' => Booking::EXPIRED]);

                sendNotification($model->customer_id, [
                    'booking_id'    => $model->id,
                    'category'      => 'booking_cancel',
                    'body'          => $msg
                ]);
            }
        }
    }
}
