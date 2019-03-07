<?php

namespace Joeelia\AuthorizeNet\Payments;


use DateTime;
use Carbon\Carbon;
use Joeelia\AuthorizeNet\AuthorizeNet;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Payments\PaymentRepo;


class Payment
{
   
    public function __construct() {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('authorize-net-webhooks.apiLogin'));
        $merchantAuthentication->setTransactionKey(config('authorize-net-webhooks.transcationKey'));
        $this->merchantAuthentication = $merchantAuthentication;

        $this->Repo = New PaymentRepo;
    }
    
    public function chargeCreditCard($amount)
    {
        $response = $this->Repo->chargeCreditCard($amount,$this->merchantAuthentication);
        return $response;
	}

}
