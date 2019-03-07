<?php
return [
    'apiLogin' => '<your login API>',

    'transcationKey' => '<your transcation key>',
    /*
     * Authorize.Net will sign each webhook using a secret. You can find the used secret at the
     * API Credentials & Keys settings: ACCOUNT>Settings>API Credentials & Keys>New Signature Key.
     */
    'signing_secret' => '<your signing secret>',
    /*
     * You can define the job that should be run when a certain webhook hits your application
     * here. The key is the name of the Authorize.Net event type with the `.` replaced by a `_`.
     *
     * You can find a list of Stripe webhook types here:
     * https://developer.authorize.net/api/reference/features/webhooks.html#Event_Types_and_Payloads
     */
    'webhookPostRoute' => '/authnet/webhook',

    'eventWebhooks' => [
        'net_authorize_customer_created' => False, //App\WebhookJobs\NetAuthorizeCustomerCreated::class,
        'net_authorize_customer_deleted' => False, //App\WebhookJobs\NetAuthorizeCustomerDeleted::class,
        'net_authorize_customer_updated' => False, //App\WebhookJobs\NetAuthorizeCustomerUpdated::class,
        'net_authorize_customer_paymentProfile_created'=> False, //App\WebhookJobs\NetAuthorizeCustomerPaymentProfileCreated::class,
        'net_authorize_customer_paymentProfile_deleted'=> False, //App\WebhookJobs\NetAuthorizeCustomerCustomerPaymentProfileDeleted::class,
        'net_authorize_customer_paymentProfile_updated'=> False, //App\WebhookJobs\NetAuthorizeCustomerPaymentProfileUpdated::class,
        'net_authorize_customer_subscription_cancelled'=> False, //App\WebhookJobs\NetAuthorizeCustomerSubscriptionCancelled::class,
        'net_authorize_customer_subscription_created'=> False, //App\WebhookJobs\NetAuthorizeCustomerSubscriptionCreated::class,
        'net_authorize_customer_subscription_expiring'=> False, //App\WebhookJobs\NetAuthorizeCustomerSubscriptionExpiring::class,
        'net_authorize_customer_subscription_suspended'=> False, //App\WebhookJobs\NetAuthorizeCustomerSubscriptionSuspended::class,
        'net_authorize_customer_subscription_terminated'=> False, //App\WebhookJobs\NetAuthorizeCustomerSubscriptionTerminated::class,
        'net_authorize_customer_subscription_updated'=> False, //App\WebhookJobs\NetAuthorizeCustomerSubscriptionUpdated::class,
        'net_authorize_payment_authcapture_created'=> False, //App\WebhookJobs\NetAuthorizePaymentAuthCaptureCreated::class,
        'net_authorize_payment_authorization_created'=> False, //App\WebhookJobs\NetAuthorizePaymentAuthorizationCreated::class,
        'net_authorize_payment_capture_created'=> False, //App\WebhookJobs\NetAuthorizePaymentCaptureCreated::class,
        'net_authorize_payment_fraud_approved'=> False, //App\WebhookJobs\NetAuthorizePaymentFraudApproved::class,
        'net_authorize_payment_fraud_declined'=> False, //App\WebhookJobs\NetAuthorizePaymentFraudDeclined::class,
        'net_authorize_payment_fraud_held'=> False, //App\WebhookJobs\NetAuthorizePaymentFraudHeld::class,
        'net_authorize_payment_priorAuthCapture_created'=> False, //App\WebhookJobs\NetAuthorizePaymentPriorAuthCaptureCreated::class,
        'net_authorize_payment_refund_created'=> False, //App\WebhookJobs\NetAuthorizePaymentRefundCreated::class,
        'net_authorize_payment_void_created' => False, //App\WebhookJobs\NetAuthorizePaymentVoidCreated::class
    ],
    
];