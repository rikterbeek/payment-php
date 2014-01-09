<?php
/**
 * Request recurring contract details 
 * 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/5.Recurring/soap/request-recurring-contract.php 
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
  * To request the recurring contract details for a shopper you have to send a
  * RecurringDetailsRequest this protocol is defined in the WSDL. The following parameters are used:
  * - merchantAccount: The merchant account the payment was processed with.
  * - shopperReference: The reference to the shopper. This shopperReference must be the same as the 
  *   shopperReference used in the initial payment. modificationAmount: The amount to capture
  * - recurring->contract: This should be the same value as recurringContract in the payment where the recurring
  *   contract was created. However if ONECLICK,RECURRING was specified initially
  *   then this field can be either ONECLICK or RECURRING.
  */
 try{
	 
	$result = $client->listRecurringDetails(array(
			"request" => array (
				"merchantAccount" => "YourMerchantAccount",
				"shopperReference" => "TheShopperreference",
	            "recurring"=> array(
					"contract" => "ONECLICK,RECURRING" // i.e.: "ONECLICK","RECURRING" or "ONECLICK,RECURRING"
				) 
			)
		)
	);
		
	/**
	 * The response will be a result with a list of zero or more details containing the following:
	 * - recurringDetailReference: The reference the details are stored under.
	 * - variant: The payment method (e.g. mc, visa, elv, ideal, paypal)
	 * - creationDate: The date when the recurring details were created.
	 * 
	 * The recurring contracts are stored in the same object types as you would have 
	 * submitted in the initial payment. 
	 */
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($exception);
	 print("<pre>");
 }
