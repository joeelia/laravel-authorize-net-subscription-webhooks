<?php

namespace Joeelia\AuthorizeNet\Subscriptions;


use DateTime;
use Carbon\Carbon;
use Joeelia\AuthorizeNet\AuthorizeNet;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Subscriptions\SubscriptionRepo;


class Subscription
{
   
    public function __construct() {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('authorize-net-webhooks.apiLogin'));
        $merchantAuthentication->setTransactionKey(config('authorize-net-webhooks.transcationKey'));
        $this->merchantAuthentication = $merchantAuthentication;

        $this->Repo = New SubscriptionRepo;
    }
    
    public function details($subscriptionId)
    {
        $response = $this->Repo->subscriptionDetail($subscriptionId,$this->merchantAuthentication);
        return $response;
    }
    public function createReoccuring($customerProfileId,$customerPaymentProfileId,$customerAddressId)
    {
        $response = $this->Repo->reoccur($customerProfileId,$customerPaymentProfileId,$customerAddressId,$this->merchantAuthentication);
        return $response;
	}

}
