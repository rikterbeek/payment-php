<?php
/**
 * Create Payment through the API using a 3D secure enrolled card
 * 
 * Payments can be created through our API, however this is only possible if you are
 * PCI Compliant. SOAP API payments are submitted using the authorise action. 
 * We will explain how a 3D secure enabled creditcard can be processed through the API. 
 * 3D secure transactionit is required to submit browserInfo to the Adyen server. 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 * 
 * @link	2.API/soap/create-payment-api-3ds.php 
 * @author	Created by Adyen
 * 
 * How does a 3D secure transaction work?
 * 1. 3D secure should be enabled for your account, please contact Adyen suppor to set it up;
 * 2. Submit a regular payment request through the authorise action providing browserInfo of the shopper;
 * 3. If 3D secure enabled, Adyen will check if the card is enabled for 3D secure;
 * 4. If the card is NOT enrolled you will receive a normal response. If the card is enabled
 *    you will receive the following extra fields: 
 * 		- paRequest: The 3D secure request for the issuer;
 * 		- md: The payment session;
 * 		- issuerUrl: The URL to redirect the shopper to;
 * 		- resultCode: The resultcode will be RedirectShopper, requiring you to redirect the shopper.
 * 5. A request should be posted to the issuerUrl to redirect the shopper. The following fields should be send:
 * 		- PaReq: The received paRequest in step 4;
 * 		- MD: The md received in step 4;
 * 		- TermUrl: the return URL that the shopper will be redirected to after issuer authentication;
 * 6. The shopper authenticates at the issuer;
 * 7. After authentication the shopper will be redirected using a POST request to the TermUrl;
 * 8. To complete the payment request you have to submit a payment using the authorise3d action using the following fields:
 * 		- merchantAccount: Should be the same merchant account as the origial request;
 * 		- browserInfo: It is safe to use the values from the original authorise request;
 *		- md: The value of the MD parameter received from the issuer (MD);
 * 		- paResponse: The value of the PaRes parameter received from the issuer (PaRes);
 * 		- shopperIP: We recommend you sending in the shopper IP.
 * 9. Finally, the response on the authorise3d request contains a regular repsone with a resultCode.
 *  
 */

 /**
  * Create SOAP Client
  * new SoapClient($wsdl,$options)
  * - $wsdl points to the wsdl you are using;
  * - $options[login] = Your WS user;
  * - $options[password] = Your WS user's password.
  * - $options[cache_wsdl] = WSDL_CACHE_BOTH, we advice 
  *   to cache the WSDL since we usually never change it.
  */
 $client = new SoapClient(
	"https://pal-test.adyen.com/pal/Payment.wsdl", array(
		"login" => "YourWSUser",  
		"password" => "YourWSUserPassword",  
		"soap_version" => SOAP_1_1,
		"style" => SOAP_DOCUMENT,
		"encoding" => SOAP_LITERAL,
		"trace" => 1,
		"classmap" => array(),
		"cache_wsdl" => WSDL_CACHE_BOTH
	)
 );
 
 /**
  * A payment can be submitted by sending a PaymentRequest 
  * to the authorise action, the request should contain the following
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
				"merchantAccount" => "JessePiscaerCOM", //YourMerchantAccount
				"amount" => array(
					"currency" => "EUR",
					"value" => "199",
				),
				"reference" => "Test payment " . date("Y-m-d H:i:s"),
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
	 */ 
	 
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
					<pre>
						<? print_r($result); ?>
					</pre>
					
					<form method="POST" action="<?=$result->paymentResult->issuerUrl ?>" id="3dform" target="_blank">
						<input type="hidden" name="PaReq" value="<?=$result->paymentResult->paRequest ?>" />
						<input type="hidden" name="TermUrl" value="http://speeltuin.jessepiscaer.com/notifications-httppost.php" />
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
