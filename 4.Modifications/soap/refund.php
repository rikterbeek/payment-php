<?php
/**
 * Refund a Payment
 * 
 * Settled payments can be refunded by sending a modifiction request
 * to the refund action of the WSDL. This file shows how a settled payment 
 * can be refunded by a modification request using SOAP. 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/4.Modificaitons/refund-soap.php 
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
  * Perform refund request by sending in a 
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
	 $result = $client->refund(array(
		"modificationRequest" => array(
			"merchantAccount" => "YourMerchantAccount",
			"modificationAmount" => array(
				"currency" => "EUR",
				"value" => "199",
			),
			"originalReference" => "PspReferenceOfTheAuthorisedPayment",
			"reference" => "YourReference"
		)
	));
	
	/**
	 * If the message was syntactically valid and merchantAccount is correct you will 
	 * receive a refundReceived response with the following fields:
	 * - pspReference: A new reference to uniquely identify this modification request. 
	 * - response: In case of success, this will be [refund-received]. 
	 *   In case of an error, we will return a SOAP Fault.
	 * 
	 * Please note: The result of the refund is sent via a notification with eventCode REFUND.
	 */
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($ex);
	 print("<pre>");
 }
