<?php

namespace Joeelia\AuthorizeNet\Wehhooks\CustomerEvents;

use DateTime;
use Exception;
use Carbon\Carbon;
use Joeelia\AuthorizeNet\AuthorizeNet;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Wehhooks\CustomerEvents\CustomerEventRepo;


class CustomerEventController
{
   
    public function __construct() {
        $this->CustomerEventRepo = New CustomerEventRepo;
    }
    
    public function dispatch($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = end($eventType);
        $this->CustomerEventRepo->$method($eventPayload);
    }
   

}
