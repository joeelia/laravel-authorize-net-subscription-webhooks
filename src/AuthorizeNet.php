<?php

namespace Joeelia\AuthorizeNet;
use DateTime;
use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Joeelia\AuthorizeNet\Webhooks\AuthorizeNetWebhooksController;
use Joeelia\AuthorizeNet\Transcations\Transcation;
use Joeelia\AuthorizeNet\Subscriptions\Subscription;
use Joeelia\AuthorizeNet\Payments\Payment;
use Joeelia\AuthorizeNet\Customers\Customer;

class AuthorizeNet
{
    

    public function __construct() {
        $this->Webhook = New AuthorizeNetWebhooksController;
        $this->Transcation = New Transcation;
        $this->Subscription = New Subscription;
        $this->Payment = New Payment;
        $this->Customer = New Customer;
    }


    public function reoccur($customerProfileId,$customerPaymentProfileId, $customerAddressId) {
        /* Create a merchantAuthenticationType object with authentication details
        retrieved from the constants file */
        
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('authorize-net-webhooks.apiLogin'));
        $merchantAuthentication->setTransactionKey(config('authorize-net-webhooks.transcationKey'));
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
    

   
    function message($text){
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
