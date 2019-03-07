<?php

namespace Joeelia\AuthorizeNet\Customers;


use DateTime;
use Carbon\Carbon;
use Joeelia\AuthorizeNet\AuthorizeNet;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Customers\CustomerRepo;


class Customer
{
   
    public function __construct() {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('authorize-net-webhooks.apiLogin'));
        $merchantAuthentication->setTransactionKey(config('authorize-net-webhooks.transcationKey'));
        $this->merchantAuthentication = $merchantAuthentication;

        $this->Repo = New CustomerRepo;
    }
    
    public function create($email)
    {
        $response = $this->Repo->create($email,$this->merchantAuthentication);
        return $response;
	}

}
