<?php

namespace Joeelia\AuthorizeNet\Subscriptions;


use Joeelia\AuthorizeNet\AuthorizeNet;
use DateTime;
use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;


class SubscriptionRepo
{
   
    public function __construct() {

    }
    
    public function subscriptionDetail($subscriptionId,$merchantAuthentication)
    {
        /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
    
        // Set the transaction's refId
        $refId = 'ref' . time();
            
        // Creating the API Request with required parameters
        $request = new AnetAPI\ARBGetSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);
        $request->setIncludeTransactions(true);
            
        // Controller
        $controller = new AnetController\ARBGetSubscriptionController($request);
            
        // Getting the response
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
            
        if ($response != null) 
        {
            if($response->getMessages()->getResultCode() == "Ok")
            {
                /*
                // Success
                echo "SUCCESS: GetSubscription:" . "\n";
                // Displaying the details
                echo "Subscription Name: " . $response->getSubscription()->getName(). "\n";
                echo "Subscription amount: " . $response->getSubscription()->getAmount(). "\n";
                echo "Subscription status: " . $response->getSubscription()->getStatus(). "\n";
                echo "Subscription Description: " . $response->getSubscription()->getProfile()->getDescription(). "\n";
                echo "Customer Profile ID: " .  $response->getSubscription()->getProfile()->getCustomerProfileId() . "\n";
                echo "Customer payment Profile ID: ". $response->getSubscription()->getProfile()->getPaymentProfile()->getCustomerPaymentProfileId() . "\n";
                    $transactions = $response->getSubscription()->getArbTransactions();
                    if($transactions != null){
                foreach ($transactions as $transaction) {
                                echo "Transaction ID : ".$transaction->getTransId()." -- ".$transaction->getResponse()." -- Pay Number : ".$transaction->getPayNum()."\n";
                        }
            */
                        $json = json_encode($response->getSubscription());
                        $obj = json_decode($json,true);
                        echo $json; 
            }
            else
            {
                // Error
                echo "ERROR :  Invalid response\n";	
                $errorMessages = $response->getMessages()->getMessage();
            echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
            }
        }
        else
        {
            // Failed to get response
            echo "Null Response Error";
        }
        return $response;
	}

    public function reoccur($customerProfileId,$customerPaymentProfileId,$customerAddressId, $merchantAuthentication) {
        /* Create a merchantAuthenticationType object with authentication details
        retrieved from the constants file */
        
        // Set the transaction's refId
        $refId = 'ref' . time();
        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName("Sample Subscription");
        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength(1);
        $interval->setUnit("months");
        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        /*
        $addMonth = Carbon::now()->addMonth(); //VIEW THIS!!!
        $paymentSchedule->setStartDate(new DateTime($addMonth));
        */
        $paymentSchedule->setStartDate(new DateTime(Carbon::now()));
        $paymentSchedule->setTotalOccurrences("9999");
        $paymentSchedule->setTrialOccurrences("0");
        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount(rand(1,99999)/12.0*12);
        $subscription->setTrialAmount("0.00");
        
        $profile = new AnetAPI\CustomerProfileIdType();
        $profile->setCustomerProfileId($customerProfileId);
        $profile->setCustomerPaymentProfileId($customerPaymentProfileId);
        $profile->setCustomerAddressId($customerAddressId);
        $subscription->setProfile($profile);
        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($request);
        sleep(15);
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
        
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
        {
            echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
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
