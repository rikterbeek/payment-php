<?php
/**
 * Cancel or Refund a Payment
 * 
 * If you do not know if the payment is captured but you want to reverse 
 * the authorisation you can send a modification request to the cancelOrRefund action 
 * This file shows how a payment can be cancelled or refunded by a 
 * modification request using SOAP. 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/4.Modifications/soap/cancel-or-refund-soap.php 
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
  * Perform cancel or refund request by sending in a 
  * modificationRequest, the protocol is defined 
  * in the WSDL. The following parameters are used:
  * - merchantAccount: The merchant account the payment was processed with.
  * - originalReference: This is the pspReference that was assigned to the authorisation
  */
 try{
	 $result = $client->cancelorrefund(array(
		"modificationRequest" => array(
			"merchantAccount" => "YourMerchantAccount",
			"originalReference" => "PspReferenceOfTheAuthorisedPayment",
		)
	));
	
	/**
	 * If the message was syntactically valid and merchantAccount is correct you will receive a
	 * cancelOrRefundReceived response with the following fields:
	 * - pspReference: A new reference to uniquely identify this modification request. 
	 * - response: This will be a confirmation: [cancelOrRefund-received]. 
	 *   In case of an error, we will return a SOAP Fault.
	 * 
	 * If the payment is authorised, but not yet captured, it will be cancelled. 
	 * In other cases the payment will be fully refunded (if possible).
	 * 
	 * Please note: The actual result of the cancel or refund is sent via a notification with eventCode CANCEL_OR_REFUND.
	 */
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($ex);
	 print("<pre>");
 }
