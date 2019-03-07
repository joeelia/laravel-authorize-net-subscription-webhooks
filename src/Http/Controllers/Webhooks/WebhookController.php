<?php

namespace Joeelia\AuthorizeNet\Webhooks;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Joeelia\AuthorizeNet\Webhooks\Middlewares\VerifySignature;
use Joeelia\AuthorizeNet\Webhooks\SubscriptionEvents\SubscriptionEventController;
use Joeelia\AuthorizeNet\Wehhooks\CustomerEvents\CustomerEventController;
use Joeelia\AuthorizeNet\Webhooks\PaymentEvents\PaymentEventController;
//use App\Http\Middleware\VerifySignature;
//use App\AuthorizeWebhookCalls;

use Joeelia\AuthorizeNet\AuthorizeNet;


class AuthorizeNetWebhooksController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifySignature::class);
        $this->SubscriptionEvent = New SubscriptionEventController;
        $this->CustomerEvent = New CustomerEventController;
        $this->PaymentEvent = New PaymentEventController;
    }

    public function __invoke(Request $request)
    {
       

        $eventPayload = $request->input();
        $modelClass = New AuthorizeWebhookCalls;//change this to be from config file like config('stripe-webhooks.model')
        $authorizeWebhookCall = $modelClass::create([
            'type' =>  $eventPayload['eventType'] ?? '',
            'payload' => $eventPayload,
        ]);
        $AuthorizeNet = New AuthorizeNet;
        $entityName = $eventPayload['payload']['entityName'];
       
        $customerEvents = array('net.authorize.customer.created','net.authorize.customer.deleted','net.authorize.customer.updated','net.authorize.customer.paymentProfile.created','net.authorize.customer.paymentProfile.deleted','net.authorize.customer.paymentProfile.updated');
        $subscriptionEvents = array('net.authorize.customer.subscription.cancelled','net.authorize.customer.subscription.created','net.authorize.customer.subscription.expiring','net.authorize.customer.subscription.suspended','net.authorize.customer.subscription.terminated','net.authorize.customer.subscription.updated');
        $paymentEvents = array('net.authorize.payment.authcapture.created','net.authorize.payment.authorization.created','net.authorize.payment.capture.created','net.authorize.payment.fraud.approved','net.authorize.payment.fraud.declined','net.authorize.payment.fraud.held','net.authorize.payment.priorAuthCapture.created','net.authorize.payment.refund.created','net.authorize.payment.void.created');
        if(in_array($eventPayload['eventType'], $customerEvents)) {
            $this->CustomerEvent->dispatch($eventPayload);
            return response()->json(['message' => 'ok'],200);
        }
        if(in_array($eventPayload['eventType'], $subscriptionEvents)) {
            $this->SubscriptionEvent->dispatch($eventPayload);
            return response()->json(['message' => 'ok'],200);
        }
        if(in_array($eventPayload['eventType'], $paymentEvents )) {
            $this->PaymentEvent->dispatch($eventPayload);
            return response()->json(['message' => 'ok'],200);
        }
        
        /*
        if($entityName == "transaction" ){
            $AuthorizeNet->webhookTransactionControl($eventPayload);
        }
        
        if($entityName == "subscription" ){
            $AuthorizeNet->webhookSubscriptionControl($eventPayload);
        }

        if($entityName == "customerProfile" ){
            /*
            {  
                "notificationId":"efb1dd8c-90de-41aa-be77-19d6f3135e83",
                "eventType":"net.authorize.customer.created",
                "eventDate":"2019-03-03T19:58:47.8681518Z",
                "webhookId":"e472be90-f6c9-429f-a2f7-58ac825b5043",
                "payload":{  
                    "paymentProfiles":[  
                        {  
                            "customerType":"individual",
                            "id":"1831339510"
                        }
                    ],
                    "merchantCustomerId":"M_1551643127",
                    "description":"Customet PHP",
                    "entityName":"customerProfile",
                    "id":"1918225585"
                }
            }
            */
            /*
        }

        if($entityName == "customerPaymentProfile" ){
            /*
            {  
            "notificationId":"40541aa3-d0f6-455e-8b3f-c9fc23225dae",
            "eventType":"net.authorize.customer.paymentProfile.created",
            "eventDate":"2019-03-03T20:12:31.4865882Z",
            "webhookId":"e472be90-f6c9-429f-a2f7-58ac825b5043",
            "payload":{  
                "customerProfileId":1918225618,
                "customerType":"individual",
                "entityName":"customerPaymentProfile",
                "id":"1831339542"
                }
            }
            */
            /*
        }
    */

    
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
