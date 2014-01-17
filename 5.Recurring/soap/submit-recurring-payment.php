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
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/5.Recurring/soap/submit-recurring-payment.php 
 * @author	Created by Adyen Payments
 */
 
 libxml_disable_entity_loader(false);
 ini_set("soap.wsdl_cache_enabled", "0");
 
 /**
  * Create SOAP Client
  * new SoapClient($wsdl,$options)
  * - $wsdl points to the wsdl you are using;
  * - $options[login] = Your WS user;
  * - $options[password] = Your WS user's password.
  */
 $client = new SoapClient(
	"https://pal-test.adyen.com/pal/Payment.wsdl", array(
		"login" => "YourWSUser",
		"password" => "YourWSUserPassword", 
		"soap_version" => SOAP_1_1,
		"style" => SOAP_DOCUMENT,
		"encoding" => SOAP_LITERAL,
		"trace" => 1,
		"classmap" => array()
	)
 );
 
 /**
  * A recurring payment can be submitted by sending a PaymentRequest 
  * to the authorise action, the request should contain the following
  * variables:
  * 
  * - selectedRecurringDetailReference: The recurringDetailReference you want to use for this payment. 
  *   The value LATEST can be used to select the most recently created recurring detail.
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
 try{
	$result = $client->authorise(array(
			"paymentRequest" => array(
				"selectedRecurringDetailReference" => "TheSelectedRecurringDetailReferenceContract",
				"recurring" => array(
					"contract" => "ONECLICK,RECURRING" // i.e.: "ONECLICK","RECURRING" or "ONECLICK,RECURRING"
				),
				"merchantAccount" => "YourMerchantAccount",
				"amount" => array(
					"currency" => "EUR",
					"value" => "199",
				),
				"reference" => "YourReference",
				"shopperEmail" => "ShopperEmailAddress",
				"shopperReference" => "ShopperReference",
				"shopperInteraction" => "ContAuth", // ContAuth for RECURRING or Ecommerce for ONECLICK 
				"fraudOffset" => "0",
				"shopperIP" => "ShopperIPAddress",
				"shopperStatement" => "", 
			)
		)
	);
	 
	/**
	 * If the recurring payment message passes validation a risk analysis will be done and, depending on the
	 * outcome, an authorisation will be attempted. You receive a
	 * payment response with the following fields:
	 * - pspReference: The reference we assigned to the payment;
	 * - resultCode: The result of the payment. One of Authorised, Refused or Error;
	 * - authCode: An authorisation code if the payment was successful, or blank otherwise;
	 * - refusalReason: If the payment was refused, the refusal reason.
	 */ 
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($exception);
	 print("<pre>");
 }
