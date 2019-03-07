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
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_paymentProfile_created') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerPaymentProfileCreated($eventPayload);
        }
    }
    public function paymentProfileDeleted($eventPayload){
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_paymentProfile_updated') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerPaymentProfileDeleted($eventPayload);
        }
    }
    public function paymentProfileUpdated($eventPayload){
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_paymentProfile_updated') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerPaymentProfileUpdated($eventPayload);
        }
    }
    public function customerCreated($eventPayload){
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_created') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerCreated($eventPayload);
        }
    }
    public function customerDeleted($eventPayload){
         if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_deleted') === True){
             New \App\WebhookJobs\NetAuthorizeCustomerDeleted($eventPayload);
         }
        
    }
    public function customerUpdated($eventPayload){
        if(config('authorize-net-webhooks.eventWebhooks.net_authorize_customer_updated') === True){
            New \App\WebhookJobs\NetAuthorizeCustomerUpdated($eventPayload);
        }
    }
}
