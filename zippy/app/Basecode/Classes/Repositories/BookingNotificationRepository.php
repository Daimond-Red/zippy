<?php

namespace App\Basecode\Classes\Repositories;



class BookingNotificationRepository extends Repository {


	public $model = '\App\BookingNotification';


	public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);

        $model = new $this->model;
        $model->fill($attrs);
        $model->save();

        

        if( request('customer_id') || request('vendor_id')) {
        	$i = 0;

	        if(request('customer_id')) $userIds[$i++] = request('customer_id');

	        if(request('vendor_id')) $userIds[$i++] = request('vendor_id');

            sendNotification($userIds, [
                'booking_id'       		=> $model->booking_id,
                'category'              => 'create_notification',
                'body'                  => request('message')
            ]);

        }

        return $model;
    }
}