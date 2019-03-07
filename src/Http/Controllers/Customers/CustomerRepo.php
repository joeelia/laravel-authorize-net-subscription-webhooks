<?php

namespace Joeelia\AuthorizeNet\Customers;


use Joeelia\AuthorizeNet\AuthorizeNet;
use DateTime;
use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;


class CustomerRepo
{
   
    public function __construct() {

    }
    
    public function create($email,$merchantAuthentication){
            // Set the transaction's refId
            $refId = 'ref' . time();
            // Create a Customer Profile Request
            //  1. (Optionally) create a Payment Profile
            //  2. (Optionally) create a Shipping Profile
            //  3. Create a Customer Profile (or specify an existing profile)
            //  4. Submit a CreateCustomerProfile Request
            //  5. Validate Profile ID returned
            // Set credit card information for payment profile
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber("4242424242424242");
            $creditCard->setExpirationDate("2030-12");
            $creditCard->setCardCode("143");
            $paymentCreditCard = new AnetAPI\PaymentType();
            $paymentCreditCard->setCreditCard($creditCard);
            // Create the Bill To info for new payment type
            $billTo = new AnetAPI\CustomerAddressType();
            $billTo->setFirstName("Joe");
            $billTo->setLastName("hawk");
            $billTo->setCompany("Souveniropolis");
            $billTo->setAddress("14 Main Street");
            $billTo->setCity("Pecan Springs");
            $billTo->setState("TX");
            $billTo->setZip("44628");
            $billTo->setCountry("US");
            $billTo->setPhoneNumber("");
            $billTo->setfaxNumber("");
            // Create a customer shipping address
            $customerShippingAddress = new AnetAPI\CustomerAddressType();
            $customerShippingAddress->setFirstName("James");
            $customerShippingAddress->setLastName("White");
            $customerShippingAddress->setCompany("Addresses R Us");
            $customerShippingAddress->setAddress(rand() . " North Spring Street");
            $customerShippingAddress->setCity("Saginar");
            $customerShippingAddress->setState("MI");
            $customerShippingAddress->setZip("08753");
            $customerShippingAddress->setCountry("US");
            $customerShippingAddress->setPhoneNumber("");
            $customerShippingAddress->setFaxNumber("");
            // Create an array of any shipping addresses
            $shippingProfiles[] = $customerShippingAddress;
            // Create a new CustomerPaymentProfile object
            $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
            $paymentProfile->setCustomerType('individual');
            $paymentProfile->setBillTo($billTo);
            $paymentProfile->setPayment($paymentCreditCard);
            $paymentProfile->setDefaultpaymentProfile(true);
            $paymentProfiles[] = $paymentProfile;
            // Create a new CustomerProfileType and add the payment profile object
            $customerProfile = new AnetAPI\CustomerProfileType();
            $customerProfile->setDescription("Customet PHP");
            $customerProfile->setMerchantCustomerId("M_" . time());
            $customerProfile->setEmail($email);
            $customerProfile->setpaymentProfiles($paymentProfiles);
            $customerProfile->setShipToList($shippingProfiles);
            // Assemble the complete transaction request
            $request = new AnetAPI\CreateCustomerProfileRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setProfile($customerProfile);
    
            $controller = new AnetController\CreateCustomerProfileController($request);
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
    
    
    
           
    
            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
                $custprofileId = $response->getCustomerProfileId();
                echo "Succesfully created customer profile : " . $custprofileId . "\n";
                $paymentProfiles = $response->getCustomerPaymentProfileIdList();
                echo "SUCCESS: PAYMENT PROFILE ID : " . $paymentProfiles[0] . "\n";
                $shippingProfiles = $response->getcustomerShippingAddressIdList();
                echo "SUCCESS: SHIPPING ID : " . $shippingProfiles[0] . "\n";
                
               
            } else {
                echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
                echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
            }
            
            return $response;
        
        
    }
    

}
