<?php

namespace Joeelia\AuthorizeNet\Webhooks\PaymentEvents;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use DateTime;
use Carbon\Carbon;
use Joeelia\AuthorizeNet\AuthorizeNet;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Webhooks\PaymentEvents\PaymentEventRepo;


class PaymentEventController
{
    public function __construct() {
        $this->PaymentEventRepo = New PaymentEventRepo;
    }

    public function dispatch($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = end($eventType);
        $this->PaymentEventRepo->$method($eventPayload);

    }
}
