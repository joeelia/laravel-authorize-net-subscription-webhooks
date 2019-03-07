<?php

namespace Joeelia\AuthorizeNet\Transcations;


use DateTime;
use Carbon\Carbon;
use Joeelia\AuthorizeNet\AuthorizeNet;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Transcations\TranscationRepo;


class Transcation
{
    public function __construct() {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('authorize-net-webhooks.apiLogin'));
        $merchantAuthentication->setTransactionKey(config('authorize-net-webhooks.transcationKey'));
        $this->merchantAuthentication = $merchantAuthentication;

        $this->Repo = New TranscationRepo;
    }
   
    public function details($transactionId)
    {
        $response = $this->Repo->transactionDetail($transactionId,$this->merchantAuthentication);
        return $response;
    }

}
