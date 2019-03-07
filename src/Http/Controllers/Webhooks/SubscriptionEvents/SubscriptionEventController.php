<?php

namespace Joeelia\AuthorizeNet\Webhooks\SubscriptionEvents;


use DateTime;
use Carbon\Carbon;
use Joeelia\AuthorizeNet\AuthorizeNet;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Webhooks\SubscriptionEvents\SubscriptionEventRepo;


class SubscriptionEventController
{

    public function __construct() {
        $this->SubscriptionEventRepo = New SubscriptionEventRepo;
    }

    public function dispatch($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = end($eventType);
        $this->SubscriptionEventRepo->$method($eventPayload);
    }

}
