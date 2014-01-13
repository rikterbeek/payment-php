<?php
/**
 * Create Payment through the API and handle 3DS
 * 
 * SOAP API payments are submitted using the authorise3d action. We will explain a credit 
 * card enables in 3D secure submission. Please note that for 3D secure transaction
 * it is required to submit browserInfo to the Adyen server. Also, access to the authorise 
 * action in the API requires you to be PCI compliant and will be enabled after 
 * you have provided us with the proper documentation. 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/2.API/soap/create-payment-api-3ds.php 
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
  * A payment can be submitted by sending a PaymentRequest 
  * to the authorise3d action, the request should contain the following
  * variables:
  * 
  * - merchantAccount: The merchant account the payment was processed with.
  * - amount: The amount of the payment
  * 	- currency: the currency of the payment
  * 	- amount: the amount of the payment
  * - reference: Your reference
  * - shopperIP: The IP address of the shopper (optional/recommended)
  * - shopperEmail: The e-mail address of the shopper 
  * - shopperReference: The shopper reference, i.e. the shopper ID
  * - fraudOffset: Numeric value that will be added to the fraud score (optional)
  * - card
  * 	- billingAddress: we advice you to submit billingAddress data if available for risk checks;
  * 		- street: The street name
  * 		- postalCode: The postal/zip code.
  * 		- city: The city
  * 		- houseNumberOrName:
  * 		- stateOrProvince: The house number
  * 		- country: The country
  * 	- expiryMonth: The expiration date's month written as a 2-digit string, padded with 0 if required (e.g. 03 or 12).
  * 	- expiryYear: The expiration date's year written as in full. e.g. 2016.
  * 	- holderName: The card holder's name, aas embossed on the card.
  * 	- number: The card number.
  * 	- cvc: The card validation code. This is the the CVC2 code (for MasterCard), CVV2 (for Visa) or CID (for American Express).
  * - browserInfo - This is required for 3D secure
  * 	- acceptHeader: the headers
  * 	- userAgent: the shopper's user agent.
  */
  
 try{

	$result = $client->authorise(array(
			"paymentRequest" => array(
				"merchantAccount" => "YourMerchantAccount", 
				"amount" => array(
					"currency" => "EUR",
					"value" => "199",
				),
				"reference" => "Test payment",
				"shopperIP" => "ShopperIPAddress", 
				"shopperEmail" => "TheShopperEmailAddress", 
				"shopperReference" => "YourReference",
				"fraudOffset" => "0",
				"card" => array( 	// Please use the 3D secure enabled test card.
					"billingAddress" => array(
						"street" => "Simon Carmiggeltstraat",
						"postalCode" => "1011 DJ",
						"city" => "Amsterdam",
						"houseNumberOrName" => "6-50",
						"stateOrProvince" => "",
						"country" => "NL",
					),
					"expiryMonth" => "06",
					"expiryYear" => "2016",
					"holderName" => "The Holder Name Here",
					"number" => "5212345678901234",
					"cvc" => "737"
				),
				"browserInfo" => array(
					"acceptHeader" => $_SERVER['HTTP_ACCEPT'],
					"userAgent" => $_SERVER['HTTP_USER_AGENT']
				),
			)
		)
	);
	
	/**
	 * If the payment passes validation a risk analysis will be done and, depending on the
	 * outcome, an authorisation will be attempted. You receive a
	 * payment response with the following fields:
	 * - pspReference: The reference we assigned to the payment;
	 * - resultCode: The result of the payment. One of Authorised, Refused, Error or in case the card is enrolled 
	 * 				 in 3D secure the resultcode will be RedirectShopper;
	 * - authCode: An authorisation code if the payment was successful, or blank otherwise;
	 * - refusalReason: If the payment was refused, the refusal reason.
	 * - additionalData: Additional data if enabled;
	 * - dccAmount: 
	 * - dccSignature
	 * - fraudResult
	 * - issuerUrl: The url the shopper should be redirected to
	 * - md: The payment session.
	 * - paRequest: The 3-D request data for the issuer.
	 * - 
	 */ 
	
	print_r($result);
	
	switch($result->paymentResult->resultCode){
		
		case "Authorised":
				// Handle authorised transaction.
			break;
		
		case "Refused":
				// Handle Refused transaction.
			break;
			
		case "Error":
				// Handle Error transaction.
			break;
		
		case "RedirectShopper":
				// Handle RedirectShopper transaction. Submit the details
				// to the issuerUrl to continue the 3D authentication.
				?>
					<form method="POST" action="<?=$result->paymentResult->issuerUrl ?>" id="3dform">
						<input type="hidden" name="PaReq" value="<?=$result->paymentResult->paRequest ?>" />
						<input type="hidden" name="TermUrl" value="https://yourwebsite.com" />
						<input type="hidden" name="MD" value="<?=$result->paymentResult->md ?>" />
						<input type="submit" value="Continue to 3D authentication"/>
					</form>
				<?
				
			break;
	}
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($ex);
	 print("<pre>");
 }
