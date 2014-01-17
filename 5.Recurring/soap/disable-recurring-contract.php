<?php
/**
 * Disable recurring contract
 * 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/5.Recurring/soap/disable-recurring-contract.php 
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
	"https://pal-test.adyen.com/pal/Recurring.wsdl", array(
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
  * Disable a recurring contract by sending a DisableRequest,
  * the protocol is defined in the WSDL. The following parameters are used:
  * - merchantAccount: The merchant account the payment was processed with.
  * - shopperReference: The reference to the shopper. This shopperReference must be the same as the 
  *   shopperReference used in the initial payment. 
  * - recurringDetailReference: The recurringDetailReference of the details you wish to 
  *   disable. If you do not supply this field all details for the shopper will be disabled including 
  *   the contract! This means that you can not add new details anymore.
  */
 try{
	 
	$result = $client->disable(array(
			"request" => array(
				"merchantAccount" => "YourMerchantAccount",
				"shopperReference" => "TheShopperreference",
				"recurringDetailReference" => "TheReferenceToTheContract",
			)
		)
	);
		
	/**
	 * The response will be a result object with a single field response. If a single detail was 
	 * disabled the value of this field will be [detail-successfully-disabled] or, if all 
	 * details are disabled, the value is [all-details-successfully-disabled].
	 */
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($exception);
	 print("<pre>");
 }
