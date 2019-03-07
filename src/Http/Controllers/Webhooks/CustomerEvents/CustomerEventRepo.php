<?php

namespace Joeelia\AuthorizeNet\Wehhooks\CustomerEvents;


use Joeelia\AuthorizeNet\AuthorizeNet;
use DateTime;
use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Webhooks\CustomerEvents\CustomerEventDispatcher;


class CustomerEventRepo
{
    public function __construct() {
        $this->CustomerEventDispatcher = New CustomerEventDispatcher;
    }

    public function created($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = $eventType[3];
        if ($method == "paymentProfile"){
            $finalMethod = $method.ucfirst($eventType[4]);
            $this->CustomerEventDispatcher->$finalMethod($eventPayload);
            //paymentProfileCreated
        } else {
            $method = $eventType[2];
            $finalMethod = $method.ucfirst($eventType[3]);
            $this->CustomerEventDispatcher->$finalMethod($eventPayload);
            //customerCreated
        }
    }

    public function deleted($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = $eventType[3];
        if ($method == "paymentProfile"){
            $finalMethod = $method.ucfirst($eventType[4]);
            $this->CustomerEventDispatcher->$finalMethod($eventPayload);
	        //paymentProfileDeleted
        } else {
            $method = $eventType[2];
            $finalMethod = $method.ucfirst($eventType[3]);
            $this->CustomerEventDispatcher->$finalMethod($eventPayload);
            //customerDeleted
        }
    }

    public function updated($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = $eventType[3];
        if ($method == "paymentProfile"){
            $finalMethod = $method.ucfirst($eventType[4]);
            $this->CustomerEventDispatcher->$finalMethod($eventPayload);
	        //paymentProfileUpdated
        } else {
            $method = $eventType[2];
            $finalMethod = $method.ucfirst($eventType[3]);
            $this->CustomerEventDispatcher->$finalMethod($eventPayload);
            //customerUpdated
        }
    }
}
