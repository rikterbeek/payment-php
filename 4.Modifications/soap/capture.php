<?php
/**
 * Capture a Payment
 * 
 * Authorised (card) payments can be captured to charge the shopper. 
 * Payments can be automatically captured by our platform. A payment can
 * also be captured by performing an API call. In order to capture an authorised 
 * (card) payment you have to send a modification request. This file
 * shows how an authorised payment should be captured by sending 
 * a modification request using SOAP. 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/4.Modificaitons/capture-soap.php 
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
  * Perform capture request by sending in a 
  * modificationRequest, the protocol is defined 
  * in the WSDL. The following parameters are used:
  * - merchantAccount: The merchant account the payment was processed with.
  * - modificationAmount: The amount to capture
  * 	- currency: the currency must match the original payment
  * 	- amount: the value must be the same or less than the original amount
  * - originalReference: This is the pspReference that was assigned to the authorisation
  * - reference: If you wish, you can to assign your own reference or description to the modification. 
  */
 try{
	 $result = $client->capture(array(
		"modificationRequest" => array(
			"merchantAccount" => "YourMerchantAccount",
			"modificationAmount" => array(
				"currency" => "EUR",
				"value" => "199",
			),
			"originalReference" => "PspReferenceOfTheAuthorisedPayment",
			"reference" => "YourReference"
		)
	);
	
	/**
	 * The response. In case of success this will be [capture-received]. 
	 * In case of an error, we will return a SOAP Fault.
	 * 
	 * Please note: The result of the capture is sent via a notification with eventCode CAPTURE.
	 */ 
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($exception);
	 print("<pre>");
 }
