<?php

namespace Joeelia\AuthorizeNet\Wehhooks\Exceptions;

use Exception;

class AuthorizeNetWebhookFailed extends Exception
{
    public static function missingSignature()
    {
        return new static('The request did not contain a header named `X-Anet-Signature`.');
    }

    public static function invalidSignature($sig,$signature)
    {
        return new static("The signature `{$signature}` found in the header named `X-Anet-Signature` does not equal the generated sha512={$sig}`. Make sure that the `config(authorize-net-webhooks.signing_secret)` config key is set to the value you found on the SAuthorize.net API settings. If you are caching your config try running `php artisan cache:clear` to resolve the problem. If its not a configuration error and thw two signatures look very different, you might be getting hacked!");
    }

    public static function signingSecretNotSet()
    {
        return new static('The Authorize.Net webhook signing secret is not set. Make sure that the `config(authorize-net-webhooks.signing_secret)` config key is set to the value you found on the Authorize.net API settings.');
    }
    
    public static function signingSecretDoesNotMatchHeader(string $sig, string $signatureStr)
    {
        return new static("Signing secret of ". $sig . "does not match " . $signatureStr . ", maybe somebody tried to hack you or your signing_key is not valid.");
    }

    public static function missingType(StripeWebhookCall $webhookCall)
    {
        return new static("Webhook call id `{$webhookCall->id}` did not contain a type. Valid Stripe webhook calls should always contain a type.");
    }
    
    public function render($request)
    {
        return response(['error' => $this->getMessage()], 400);
    }
}
