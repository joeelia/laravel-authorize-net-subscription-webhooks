<?php

namespace Joeelia\AuthorizeNet\Transcations;


use Joeelia\AuthorizeNet\AuthorizeNet;
use DateTime;
use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;


class TranscationRepo
{
   
    public function transactionDetail($transactionId,$merchantAuthentication)
    {
        /* Create a merchantAuthenticationType object with authentication details
        retrieved from the constants file */
        
     
        // Set the transaction's refId
        // The refId is a Merchant-assigned reference ID for the request.
        // If included in the request, this value is included in the response. 
        // This feature might be especially useful for multi-threaded applications.
        $refId = 'ref' . time();

        $request = new AnetAPI\GetTransactionDetailsRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransId($transactionId);

        $controller = new AnetController\GetTransactionDetailsController($request);

        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
        {
            /*
            echo "SUCCESS: Transaction Status:" . $response->getTransaction()->getTransactionStatus() . "\n";
            echo "                Auth Amount:" . $response->getTransaction()->getAuthAmount() . "\n";
            echo "                   Trans ID:" . $response->getTransaction()->getTransId() . "\n";
            echo "                   Auth Code:" . $response->getTransaction()->getAuthCode() . "\n";
            echo "                   Settle:" . $response->getTransaction()->getAuthCode() . "\n";

            echo "                   subscription:" . $response->getTransaction()->getSubscriptionId()->id;
                    */
            $json = json_encode($response->getTransaction());
            $obj = json_decode($json,true);
            echo $json;
            /*
            if (!isset($obj['subscription']['id'])){
                //payment captured from one time purchase AIM
            } else {
                //payment captured from ARB
                echo $obj['subscription']['id'];
            }
            echo $obj['customer']['id'];
            echo $obj['customer']['email'];
            return $obj;
            */
        }
        else
        {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
        }

        return $response;
    }

}
 