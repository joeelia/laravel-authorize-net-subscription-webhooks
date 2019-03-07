<?php

namespace Joeelia\AuthorizeNet\Webhooks;

use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\AuthorizeNetWebhookFailed as WebhookFailed;

class AuthorizeWebhookCalls extends Model
{
    public $guarded = [];
    protected $casts = [
        'payload' => 'array',
        'exception' => 'array',
    ];

    public static function generateSH512($payload, $secret, $signature)
    {
        if ($payload != null && $secret != null) {
            //makes sure that people aren't sending you fake webhooks to get free subscriptions....
            //force string to uppercase so it matches the header
            /* 
            Replace the below line with this:
            $sig = hash_hmac('sha512', $payload, $secret);
            If you want to see the middleware in its failed state, its a slightly different code that returns lowercase so it fails
            the script is very strict because if it doesn't match excatly then it wont pass, we are dealing with money here after all.
            */
            $sig = strtoupper(hash_hmac('sha512', $payload, $secret));
            $signatureStr = substr($signature, strlen('sha512='));
            if ($sig === $signatureStr){
                return true;
            } else{
                throw WebhookFailed::invalidSignature($sig, $signature);
            }
        } else {
            throw WebhookFailed::missingSignature();
        }
    }

}
