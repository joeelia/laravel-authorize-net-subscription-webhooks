<?php

namespace Joeelia\AuthorizeNet\Webhooks\PaymentEvents;


use DateTime;
use Carbon\Carbon;
use Joeelia\AuthorizeNet\AuthorizeNet;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Webhooks\PaymentEvents\PaymentEventDispatcher;


class PaymentEventRepo
{
    public function __construct() {
        $this->PaymentEventDispatcher = New PaymentEventDispatcher;
    }
    public function created($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = $eventType[3];
        $this->PaymentEventDispatcher->$method($eventPayload);
    }

    public function approved($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = $eventType[3];
        $this->PaymentEventDispatcher->$method($eventPayload);
    }

    public function declined($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = $eventType[3];
        $this->PaymentEventDispatcher->$method($eventPayload);
    }

    public function held($eventPayload){
        $eventType = explode('.',$eventPayload['eventType']);
        $method = $eventType[3];
        $this->PaymentEventDispatcher->$method($eventPayload);
    }

    public function cancelled($eventPayload){
        
    }

    public function expiring($eventPayload){
        
    }

    public function suspended($eventPayload){
        
    }

    public function terminated($eventPayload){
        
    }

    public function updated($eventPayload){
        
    }

    public function webhookSubscriptionControl($eventPayload,$subscriptionEvents)
    {
        $amount = $eventPayload['payload']['amount'];
        $transactionId = $eventPayload['payload']['id'];
        $subscriptionName = $eventPayload['payload']['name'];
        $subscriptionStatus = $eventPayload['payload']['status'];
        $customerProfileId = $eventPayload['payload']['profile']['customerProfileId'];
        $customerPaymentProfileId = $eventPayload['payload']['profile']['customerPaymentProfileId'];
        $customerShippingAddressId =$eventPayload['payload']['profile']['customerShippingAddressId'];

        if ($subscriptionStatus != "active"){
            //Subscription is NOT ACTIVE!
            $this->message("Subscription is ". $subscriptionStatus . " for customerProfileId: ".$customerProfileId.". They WERE paying $".$amount);
            //OOOP
        } elseif ($subscriptionStatus = "active") {
            //Subscription IS ACTIVE!
            $this->message("Subscription is ". $subscriptionStatus . " for customerProfileId: ".$customerProfileId.". They are paying $".$amount. "a month!");
            $things="subscription things";
            return $things;
        } else{
            $this->message("Subscription is ". $subscriptionStatus . " for customerProfileId: ".$customerProfileId);
        }
    }

    public function message($text){
        $url1 = "https://api.telegram.org/bot545310390:AAHWO6DJCvimklYkFJKxYRbhwJwnE2HLubg/sendMessage?chat_id=-1001336256280&text=";
        $url = $url1 . $text;
        $ch = curl_init();
        $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
    }
    

}
