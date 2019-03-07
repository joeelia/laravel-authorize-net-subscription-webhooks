<?php

namespace Joeelia\AuthorizeNet\Webhooks\Middlewares;

use Exception;
use Closure;
use Joeelia\AuthorizeNet\Wehhooks\Exceptions\AuthorizeNetWebhookFailed as WebhookFailed;
use Joeelia\AuthorizeNet\Webhooks\AuthorizeWebhookCalls as Webhook;

class VerifySignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
        $signature = $request->header('X-Anet-Signature');
        if (! $signature) {
            throw WebhookFailed::missingSignature();
        }
        if (! $this->isValid($signature, $request->getContent())) {
            
            $secret = config('authorize-net-webhooks.signing_secret');
            $sig = strtoupper(hash_hmac('sha512', $request->getContent(), $secret));
           //You can log that signature didn't pass here, maybe someone trying to hack you?
            throw WebhookFailed::invalidSignature($sig,$signature);
        } else {
            //Signature passed, you can log this there
        }

        return $next($request);
    }

    protected function isValid(string $signature, string $payload): bool
    {
        $secret = config('authorize-net-webhooks.signing_secret');
        if (empty($secret)) {
            throw WebhookFailed::signingSecretNotSet();
        }
        try {
            Webhook::generateSH512($payload, $secret, $signature);
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }
    
}
