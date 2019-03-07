<?php

namespace Joeelia\AuthorizeNet\Webhooks\SubscriptionEvents;


use Joeelia\AuthorizeNet\AuthorizeNet;
use DateTime;
use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;


class SubscriptionEventRepo
{
    public function created($eventPayload){
        /*
        {  
            "notificationId":"43593773-f0c0-4540-afea-698a9ee7fac4",
            "eventType":"net.authorize.customer.subscription.created",
            "eventDate":"2019-03-05T05:15:34.8600996Z",
            "webhookId":"e472be90-f6c9-429f-a2f7-58ac825b5043",
            "payload":{  
                "name":"Sample Subscription",
                "amount":55961,
                "status":"active",
                "profile":{  
                    "customerProfileId":1918246648,
                    "customerPaymentProfileId":1831362174,
                    "customerShippingAddressId":1875474275
                },
                "entityName":"subscription",
                "id":"5658870"
            }
        }
        */
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_subscription_created') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerSubscriptionCreated($eventPayload);
        }
    }

    public function cancelled($eventPayload){
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_subscription_cancelled') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerSubscriptionCancelled($eventPayload);
        }
    }

    public function expiring($eventPayload){
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_subscription_expiring') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerSubscriptionExpiring($eventPayload);
        }
    }

    public function suspended($eventPayload){
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_subscription_suspended') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerSubscriptionSuspended($eventPayload);
        }
    }

    public function terminated($eventPayload){
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_subscription_terminated') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerSubscriptionTerminated($eventPayload);
        }
    }

    public function updated($eventPayload){
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_subscription_updated') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerSubscriptionUpdated($eventPayload);
        }
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
}
