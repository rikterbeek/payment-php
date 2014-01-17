<?php
/**
 * Submit recurring Payment
 * 
 * You can submit a recurring payment using a specific recurringDetails record or by using the last created
 * recurringDetails record. The request for the recurring payment is done using a paymentRequest.
 * This file shows how a recurring payment can be submitted using our API.
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	5.Recurring/httppost/submit-recurring-payment.php 
 * @author	Created by Adyen Payments
 */
 
/**
  * A recurring payment can be submitted by sending a PaymentRequest 
  * to the authorise action, the request should contain the following
  * variables:
  * 
  * - selectedRecurringDetailReference: The recurringDetailReference you want to use for this payment. 
  *   The value LATEST can be used to select the most recently used recurring detail.
  * - recurring: This should be the same value as recurringContract in the payment where the recurring 
  *   contract was created. However if ONECLICK,RECURRING was specified initially
  *   then this field can be either ONECLICK or RECURRING.
  * - merchantAccount: The merchant account the payment was processed with.
  * - amount: The amount of the payment
  * 	- currency: the currency of the payment
  * 	- amount: the amount of the payment
  * - reference: Your reference
  * - shopperEmail: The e-mail address of the shopper 
  * - shopperReference: The shopper reference, i.e. the shopper ID
  * - shopperInteraction: ContAuth for RECURRING or Ecommerce for ONECLICK 
  * - fraudOffset: Numeric value that will be added to the fraud score (optional)
  * - shopperIP: The IP address of the shopper (optional)
  * - shopperStatement: Some acquirers allow you to provide a statement (optional)
  */
  
  $request = array(
    "action" => "Recurring.submitRecurring",
    "recurringRequest.recurringReference" => "TheSelectedRecurringDetailReferenceContract",
	"recurringRequest.merchantAccount" => "YourMerchantAccount",
	"recurringRequest.amount.currency" => "EUR",
	"recurringRequest.amount.value" => "199",
	"recurringRequest.reference" => "YourReference",
	"recurringRequest.shopperEmail" => "ShopperEmailAddress",
	"recurringRequest.shopperReference" => "ShopperReference",
 ); 

 
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/adapter/httppost");
 curl_setopt($ch, CURLOPT_HEADER, false); 
 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC  );
 curl_setopt($ch, CURLOPT_USERPWD, "YourWSUser:YourWSUserPassword"); 
 curl_setopt($ch, CURLOPT_POST,count($request));
 curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
 $result = curl_exec($ch);
 
 if($result === false)
    echo "Error: " . curl_error($ch);
 else{

	 
 	parse_str($result,$result);
    print_r(($result));
 }
 
 curl_close($ch);
