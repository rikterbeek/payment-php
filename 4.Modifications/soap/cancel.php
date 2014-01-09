<?php
/**
 * Cancel a Payment
 *
 * Similarly to the capture modification, in order to cancel an authorised (card) 
 * payment you send a modification request to the cancel action.
 * This file shows how an authorised payment should be canceled by sending 
 * a modification request using SOAP. 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/4.Modificaitons/cancel-soap.php 
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
  * Perform cancel request by sending in a 
  * modificationRequest, the protocol is defined 
  * in the WSDL. The following parameters are used:
  * - merchantAccount: The merchant account the payment was processed with.
  * - originalReference: This is the pspReference that was assigned to the authorisation
  */
 try{
	 $result = $client->cancel(array(
		"modificationRequest" => array(
			"merchantAccount" => "YourMerchantAccount",
			"originalReference" => "PspReferenceOfTheAuthorisedPayment",
		)
	);
	
	/**
	 * If the message was syntactically valid and merchantAccount is correct you will 
	 * receive a cancelReceived response with the following fields:
	 * - pspReference: A new reference to uniquely identify this modification request. 
	 * - response: In case of success, this will be [cancel-received]. 
	 *   In case of an error, we will return a SOAP Fault.
	 * 
	 * Please note: The result of the cancellation is sent via a notification with eventCode CANCELLATION.
	 */
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($exception);
	 print("<pre>");
 }
