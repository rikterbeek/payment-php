<?php
/**
 * Create Client-Side Encryption Payment (SOAP)
 * 
 * Merchants that require more stringent security protocols or do not want the additional overhead 
 * of managing their PCI compliance, may decide to implement Client-Side Encryption (CSE). 
 * This is particularly useful for Mobile payment flows where only cards are being offered, as 
 * it may result in faster load times and an overall improvement to the shopper flow.
 * The Adyen Hosted Payment Page (HPP) provides the most comprehensive level of PCI compliancy 
 * and you do not have any PCI obligations. Using CSE reduces your PCI scope when compared to 
 * implementing the API without encryption.
 * 
 * If you would like to implement CSE, please provide the completed PCI Self Assessment Questionnaire (SAQ) 
 * A to the Adyen Support Team (support@adyen.com). The form can be found here: 
 * https://www.pcisecuritystandards.org/security_standards/documents.php?category=saqs
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
 * @link	2.API/soap/create-payment-cse.php 
 * @author	Created by Adyen
 */
 
 if(isset($_POST['adyen-encrypted-data'])){
	 /**
	  * The payment can be submitted by sending a PaymentRequest 
	  * to the authorise action of the web service, the request should 
	  * contain the following variables:
	  * - merchantAccount: The merchant account the payment was processed with.
	  * - amount: The amount of the payment
	  * 	- currency: the currency of the payment
	  * 	- amount: the amount of the payment
	  * - reference: Your reference
	  * - shopperIP: The IP address of the shopper (optional/recommended)
	  * - shopperEmail: The e-mail address of the shopper 
	  * - shopperReference: The shopper reference, i.e. the shopper ID
	  * - fraudOffset: Numeric value that will be added to the fraud score (optional)
	  * - paymentRequest.additionalData.card.encrypted.json: The encrypted card catched by the POST variables.
	  */
	  
	 /**
	  * Create SOAP Client = new SoapClient($wsdl,$options)
	  * - $wsdl points to the wsdl you are using;
	  * - $options[login] = Your WS user;
	  * - $options[password] = Your WS user's password.
	  * - $options[cache_wsdl] = WSDL_CACHE_BOTH, we advice 
	  *   to cache the WSDL since we usually never change it.
	  */
	 $client = new SoapClient(
		"https://pal-test.adyen.com/pal/Payment.wsdl", array(
			"login" => "ws@Company.JessePiscaer", //YourWSUser  
			"password" => "GtrMU{mccv5R34pckSF7<Tdau", //YourWSUserPassword  
			"style" => SOAP_DOCUMENT,
			"encoding" => SOAP_LITERAL,
			"cache_wsdl" => WSDL_CACHE_BOTH
		)
	 );
		 
	 try{
		$result = $client->authorise(array(
				"paymentRequest" => array(
					"merchantAccount" => "JessePiscaerCOM", //YourMerchantAccount 
					"amount" => array(
						"currency" => "EUR",
						"value" => "199",
					),
					"reference" => "TEST-PAYMENT-" . date("Y-m-dH:i:s"),
					//"shopperIP" => "ShopperIPAddress",
					"shopperEmail" => "jesse.piscaer@adyen.com", //TheShopperEmailAddress
					"shopperReference" => "12345", //YourReference
					"fraudOffset" => "0",
					"additionalData" => array(
						array("<key>card.encrypted.json</key><value>".$_POST['adyen-encrypted-data']."</value>")	
					)
				)
			)
		);
		
		/**
		 * If the payment passes validation a risk analysis will be done and, depending on the
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
		 print($ex);
		 print("</pre>");
	 }
 }
	  
?>
 <html>
	 <head>
		 <title>Adyen - Client-Side Encryption Example</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	 </head>
	 <body>
		<form method="POST" action="#handler" id="adyen-encrypted-form">
			<fieldset>
				<legend>Card Details</legend>
					<label for="adyen-encrypted-form-number">
						Card Number
						<input type="text" id="adyen-encrypted-form-number" value="5555444433331111" size="20" autocomplete="off" data-encrypted-name="number" />
                    </label>
                    <label for="adyen-encrypted-form-holder-name">
						Card Holder Name
						<input type="text" id="adyen-encrypted-form-holder-name" value="John Doe" size="20" autocomplete="off" data-encrypted-name="holderName" />
					</label>
					<label for="adyen-encrypted-form-cvc">
						CVC
						<input type="text" id="adyen-encrypted-form-cvc" value="737" size="4" autocomplete="off" data-encrypted-name="cvc" />
					</label>
					<label for="adyen-encrypted-form-expiry-month">
						Expiration Month (MM)
						<input type="text" value="06"   id="adyen-encrypted-form-expiry-month" size="2"  autocomplete="off" data-encrypted-name="expiryMonth" /> /
					</label>
					<label for="adyen-encrypted-form-expiry-year">Expiration Year (YYYY)
						<input type="text" value="2016" id="adyen-encrypted-form-expiry-year"  size="4"  autocomplete="off" data-encrypted-name="expiryYear" />
					</label>
					
					<input type="hidden" id="adyen-encrypted-form-expiry-generationtime" value="<?=date("c") ?>" data-encrypted-name="generationtime" />
					<input type="submit" value="Create payment" />
			</fieldset>	
		</form>
		
		<script type="text/javascript" src="../../lib/adyen.encrypt.min.js"></script>
		<script type="text/javascript">
			var form    = document.getElementById('adyen-encrypted-form');
			/* Put your WS users' CSE key here */
			/* Adyen CA -> Settings -> Users -> Choose the WS user -> Copy CSE key */
			var key ="10001|90F27F14AC438986154318747F0FEEFC33703E742A04F58459B8FE"
 + "42148D2E5E5F4B23FE162EC0F699354B918E4E28FDCC8D15FDE2C6BE324F"
 + "5B25034DEBD157A0BF57FB8C88D84A45AFC0D6C3CA1D06DEE4186145D7FD"
 + "7B181630D8A7A05597616C5BF6C1517A78BCED88A2A8C446F6712B0781D6"
 + "586A088123C70E90ECD2E6655559B22C82C4C3D661CFB2F4215E6D2015CC"
 + "2C155FF369D92A75F5BDB5CCCD8655B685CBDAF375A7E34CD02664EB8BBC"
 + "06B4AA9C642E6CEEB9E7B4310D117D11FC149CE9B6960BBB44C18EAD140A"
 + "FBE5180C963F6661FCB8A3DF3A7792F8E966E653A4E6030F933D7BF17813"
 + "8FB6FE859DB9295A7EAC3F17D65CA2937AA903";
			 adyen.encrypt.createEncryptedForm( form, key, {});
		</script>
	 </body>
 </html> 
