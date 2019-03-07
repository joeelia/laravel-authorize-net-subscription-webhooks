<?php

namespace Joeelia\AuthorizeNet\Webhooks\CustomerEvents;


use DateTime;
use Carbon\Carbon;
use Joeelia\AuthorizeNet\AuthorizeNet;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;


class CustomerEventDispatcher
{
    public function paymentProfileCreated($eventPayload){
        $this->message("paymentProfileCreated FROM PACKAGE WORKS");

        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_paymentProfile_created') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerPaymentProfileCreated($eventPayload);
        }
    }
    public function paymentProfileDeleted($eventPayload){
        $this->message("paymentProfileDeleted CAPTRUE FROM PACKAGE WORKS");

        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_paymentProfile_updated') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerPaymentProfileDeleted($eventPayload);
        }
    }
    public function paymentProfileUpdated($eventPayload){
        $this->message("paymentProfileUpdated CAPTRUE FROM PACKAGE WORKS");

        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_paymentProfile_updated') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerPaymentProfileUpdated($eventPayload);
        }
    }
    public function customerCreated($eventPayload){
        $this->message("customerCreated FROM PACKAGE WORKS");

        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_created') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerCreated($eventPayload);
        }
    }
    public function customerDeleted($eventPayload){
        $this->message("customerDeleted CAPTRUE FROM PACKAGE WORKS");
        
         if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_deleted') === True){
             New \App\WebhookJobs\NetAuthorizeCustomerDeleted($eventPayload);
         }
        
    }
    public function customerUpdated($eventPayload){
        $this->message("customerUpdated CAPTRUE FROM PACKAGE WORKS");

        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_updated') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerUpdated($eventPayload);
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
