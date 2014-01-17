<?php
/**
 * Create Payment On Hosted Payment Page (HPP) Advanced
 * 
 * The Adyen Hosted Payment Pages (HPPs) provide a flexible, secure 
 * and easy way to allow shoppers to pay for goods or services. Rather
 * than submitting a simple request containing the required fields
 * we offer a possibility to post even more variables to our HPP.
 * This code example will show you which variables can be posted
 * and why.
 * 
 * @link	1.HPP/create-payment-on-hpp-advanced.php 
 * @author	Created by Adyen
 */
 
 /**
  * Defining variables
  * The HPP requires certain variables to be posted in order to create
  * a payment possibility for the shopper. 	 
  * 
  * The variables that you can post to the HPP are the following:
  * 
  * $merchantReference	: The merchant reference is your reference for the payment
  * $paymentAmount		: Amount specified in minor units EUR 1,00 = 100
  * $currencyCode		: The three-letter capitalised ISO currency code to pay in i.e. EUR
  * $shipBeforeDate		: The date by which the goods or services are shipped.
  * 					  Format: YYYY-MM-DD;
  * $skinCode			: The skin code that should be used for the payment
  * $merchantAccount	: The merchant account you want to process this payment with.
  * $sessionValidity	: The final time by which a payment needs to have been made. 
  * 					  Format: YYYY-MM-DDThh:mm:ssTZD
  * $shopperLocale		: A combination of language code and country code to specify 
  * 					  the language used in the session i.e. en_GB.
  * $orderData 			: A fragment of HTML/text that will be displayed on the HPP, for example to show the basked (optional)
  * $countryCode		: Country code according to ISO_3166-1_alpha-2 standard  (optional)
  * $shopperEmail		: The e-mailaddress of the shopper (optional)
  * $shopperReference	: The shopper reference, i.e. the shopper ID (optional)
  * $recurringContract	: Can be "ONECLICK","RECURRING" or "ONECLICK,RECURRING", this allows you to store
  * 					  the payment details as a ONECLICK and/or RECURRING contract. Please note that if you supply
  * 					  recurringContract, shopperEmail and shopperReference become mandatory. Please
  * 					  view the recurring examples in the repository as well. 
  * $allowedMethods		: Allowed payment methods separeted with a , i.e. "ideal,mc,visa" (optional)
  * $blockedMethods		: Blocked payment methods separeted with a , i.e. "ideal,mc,visa" (optional)
  * $shopperStatement	: To submit a variable shopper statement you can set the shopperStatement field in the payment request.
  * $merchantReturnData	: This field willl be passed back as-is on the return URL when the shopper completes (or abandons) the 
  * 					  payment and returns to your shop. (optional)
  * $offset				: Numeric value that will be added to the fraud score (optional)
  * $brandCode			: The payment method the shopper likes to pay with, i.e. ideal (optional)
  * $issuerId			: If brandCode specifies a redirect payment method, the issuer can be 
  * 					  defined here forcing the HPP to redirect directly to the payment method. (optional)
  * $merchantSig		: The HMAC signature used by Adyen to test the validy of the form;
  */
    
  $merchantReference = "TEST-PAYMENT-" . date("Y-m-d-H:i:s");
  $paymentAmount = 199; 	
  $currencyCode = "EUR";	
  $shipBeforeDate = date("Y-m-d",strtotime("+3 days")); 
  $skinCode = "YourSkinCode";
  $merchantAccount = "YourMerchantAccount";
  $sessionValidity = date("c",strtotime("+1 days")); 
  $shopperLocale = "en_US"; 
  $orderData = base64_encode(gzencode("Orderdata to display on the HPP can be put here"));
  $countryCode = "NL"; 
  $shopperEmail = "";
  $shopperReference = ""; 
  $recurringContract = "";
  $allowedMethods = ""; 
  $blockedMethods = ""; 
  $shopperStatement = "";
  $merchantReturnData = "";
  $offset = ""; 
  
  // By providing the brandCode and issuerId the HPP will redirect the shopper
  // directly to the redirect payment method. Please note: the form should be posted
  // to https://test.adyen.com/hpp/details.shtml rather than pay.shtml. While posting
  // to details.shtml countryCode becomes a required as well.  
  $brandCode = "";
  $issuerId = "";
  
  /**
   * Collecting Shopper Information
   * 
   * Address Verification System (AVS) is a security feature that verifies the billing address and/or 
   * delivery address and/or shopper information of the card holder. To enable AVS the Billing Address Fields 
   * (AVS) field must be checked under Skin Options for each skin you wish to use. The following variables
   * can be send to the HPP:
   * 
   * 1. Billing address;
   * - billingAddress.street: The street name
   * - billingAddress.houseNumberOrName: The house number
   * - billingAddress.city: The city.
   * - billingAddress.postalCode: The postal/zip code.
   * - billingAddress.stateOrProvince: The state or province.
   * - billingAddress.country: The country in ISO 3166-1 alpha-2 format i.e. NL. 
   * - billingAddressType: You can specify whether the shopper is allowed to view and/or modify these personal details.
   * - billingAddressSig: A separate merchant signature that is required for these fields. 
   * 
   * 2. Delivery address;
   * - deliveryAddress.street: The street name
   * - deliveryAddress.houseNumberOrName: The house number
   * - deliveryAddress.city: The city.
   * - deliveryAddress.postalCode: The postal/zip code.
   * - deliveryAddress.stateOrProvince: The state or province.
   * - deliveryAddress.country: The country in ISO 3166-1 alpha-2 format i.e. NL. 
   * - deliveryAddressType: You can specify whether the shopper is allowed to view and/or modify these personal details.
   * - deliveryAddressSig: A separate merchant signature that is required for these fields. 
   * 
   * 3. Shopper information
   * - shopper.firstName: First name of the shopper.
   * - shopper.infix: The shopper infix.
   * - shopper.lastName: The shopper lastname.
   * - shopper.gender: The shopper gender: MALE/FEMALE
   * - shopper.dateOfBirthDayOfMonth: The day of the month of the shopper's birth.
   * - shopper.dateOfBirthMonth: The month of the shopper's birth.
   * - shopper.dateOfBirthYear: The year of the shopper's birth.
   * - shopper.telephoneNumber: The shopper's telephone number.
   * - shopperType: This field can be used if validation of the shopper fiels are desired. 
   * - shopperSig: A separate merchant signature that is required for these fields. 
   * 
   * Please note: billingAddressType, deliveryAddressType and shopperType 
   * can have the following values:
   * - Not supplied: modifiable / visible;
   * - 1: unmodifiable / visible
   * - 2: unmodifiable / invisible
   */
   
   $shopperInfo = array(
		"billing" => array(
			"billingAddress.street" => "Simon Carmiggeltstraat",
			"billingAddress.houseNumberOrName" => "6-50",
			"billingAddress.city" => "Amsterdam",
			"billingAddress.postalCode" => "1011 DJ",
			"billingAddress.stateOrProvince" => "",
			"billingAddress.country" => "NL",
			"billingAddressType" => "",
		),
		"delivery" => array(
			"deliveryAddress.street" => "Simon Carmiggeltstraat",
			"deliveryAddress.houseNumberOrName" => "6-50",
			"deliveryAddress.city" => "Amsterdam",
			"deliveryAddress.postalCode" => "1011 DJ",
			"deliveryAddress.stateOrProvince" => "",
			"deliveryAddress.country" => "NL",
			"deliveryAddressType" => "1",
		),
		"shopper" => array(
			"shopper.firstName" => "John",
			"shopper.infix" => "",
			"shopper.lastName" => "Doe",
			"shopper.gender" => "MALE",
			"shopper.dateOfBirthDayOfMonth" => "05",
			"shopper.dateOfBirthMonth" => "10",
			"shopper.dateOfBirthYear" => "1990",
			"shopper.telephoneNumber" => "+31612345678",
			"shopperType" => "1",
		)
   );
  
  
  /**
   * Signing the form
   * 
   * The signatures are used by Adyen to verify if the posted data is not
   * altered by the shopper. The signature must be encrypted according to the procedure below.
   * For this code example we use HMAC Pear (http://pear.php.net/package/Crypt_HMAC/download)
   * 
   * Please note: the signature does contain more variables, in this example
   * they are NOT required since they are empty. Please have a look at the
   * advanced HPP example.
   */ 
  require_once "../lib/HMAC.php";
  
  // HMAC Key is a shared secret KEY used to encrypt the signature. Set up the HMAC 
  // key: Adyen Test CA >> Skins >> Choose your Skin >> Edit Tab >> Edit HMAC key for Test and Live 
  $hmacKey = "YourHmacSecretKey";
  $cryptHMAC = new Crypt_HMAC($hmacKey, "sha1");

  // Compute the merchantSig
  $merchantSig = base64_encode(pack("H*",$cryptHMAC->hash(
	$paymentAmount . $currencyCode . $shipBeforeDate . $merchantReference . $skinCode . $merchantAccount .
	$sessionValidity . $shopperEmail . $shopperReference . $recurringContract .  
	$allowedMethods . $blockedMethods . $shopperStatement . $merchantReturnData . 
	$shopperInfo["billing"]["billingAddressType"] . $shopperInfo["delivery"]["deliveryAddressType"] . 
	$shopperInfo["shopper"]["shopperType"] . $offset
  ))); 
  
  // Compute the billingSig
  $billingSig = base64_encode(pack("H*",$cryptHMAC->hash(
	$shopperInfo["billing"]["billingAddress.street"] .
	$shopperInfo["billing"]["billingAddress.houseNumberOrName"] .
	$shopperInfo["billing"]["billingAddress.city"] .
	$shopperInfo["billing"]["billingAddress.postalCode"] .
	$shopperInfo["billing"]["billingAddress.stateOrProvince"] .
	$shopperInfo["billing"]["billingAddress.country"]
  )));
  
  // Compute the deliverySig
  $deliveryAddressSig = base64_encode(pack("H*",$cryptHMAC->hash(
	$shopperInfo["delivery"]["deliveryAddress.street"] .
	$shopperInfo["delivery"]["deliveryAddress.houseNumberOrName"] .
	$shopperInfo["delivery"]["deliveryAddress.city"] .
	$shopperInfo["delivery"]["deliveryAddress.postalCode"] .
	$shopperInfo["delivery"]["deliveryAddress.stateOrProvince"] .
	$shopperInfo["delivery"]["deliveryAddress.country"]
  )));
  
  // Compute the shopperSig
  $shopperSig = base64_encode(pack("H*",$cryptHMAC->hash(
	$shopperInfo["shopper"]["shopper.firstName"] .
	$shopperInfo["shopper"]["shopper.infix"] .
	$shopperInfo["shopper"]["shopper.lastName"] .
	$shopperInfo["shopper"]["shopper.gender"] .
	$shopperInfo["shopper"]["shopper.dateOfBirthDayOfMonth"] .
	$shopperInfo["shopper"]["shopper.dateOfBirthMonth"] . 
	$shopperInfo["shopper"]["shopper.dateOfBirthYear"] . 
	$shopperInfo["shopper"]["shopper.telephoneNumber"]
  )));

?>
<form method="POST" action="https://test.adyen.com/hpp/pay.shtml" target="_blank">
	<input type="hidden" name="merchantReference" value="<?=$merchantReference ?>"/>
	<input type="hidden" name="paymentAmount" value="<?=$paymentAmount ?>"/>
	<input type="hidden" name="currencyCode" value="<?=$currencyCode ?>"/>
	<input type="hidden" name="shipBeforeDate" value="<?=$shipBeforeDate ?>"/>
	<input type="hidden" name="skinCode" value="<?=$skinCode ?>"/>
	<input type="hidden" name="merchantAccount" value="<?=$merchantAccount ?>"/>
	<input type="hidden" name="sessionValidity" value="<?=$sessionValidity ?>"/>
	<input type="hidden" name="shopperLocale" value="<?=$shopperLocale ?>"/>
	<input type="hidden" name="orderData" value="<?=$orderData ?>"/>
	<input type="hidden" name="countryCode" value="<?=$countryCode ?>"/>
	<input type="hidden" name="shopperEmail" value="<?=$shopperEmail ?>"/>
	<input type="hidden" name="shopperReference" value="<?=$shopperReference ?>"/>
	<input type="hidden" name="recurringContract" value="<?=$recurringContract ?>"/>
	<input type="hidden" name="allowedMethods" value="<?=$allowedMethods ?>"/>
	<input type="hidden" name="blockedMethods" value="<?=$blockedMethods ?>"/>
	<input type="hidden" name="shopperStatement" value="<?=$shopperStatement ?>"/>
	<input type="hidden" name="merchantReturnData" value="<?=$merchantReturnData ?>"/>
	<input type="hidden" name="offset" value="<?=$offset ?>"/>
	<input type="hidden" name="brandCode" value="<?=$brandCode ?>"/>
	<input type="hidden" name="issuerId" value="<?=$issuerId ?>"/>
	
	<!-- Billing address -->
	<input type="hidden" name="billingAddress.street" value="<?=$shopperInfo["billing"]["billingAddress.street"] ?>"/>
	<input type="hidden" name="billingAddress.houseNumberOrName" value="<?=$shopperInfo["billing"]["billingAddress.houseNumberOrName"] ?>"/>
	<input type="hidden" name="billingAddress.city" value="<?=$shopperInfo["billing"]["billingAddress.city"] ?>"/>
	<input type="hidden" name="billingAddress.postalCode" value="<?=$shopperInfo["billing"]["billingAddress.postalCode"] ?>"/>
	<input type="hidden" name="billingAddress.stateOrProvince" value="<?=$shopperInfo["billing"]["billingAddress.stateOrProvince"] ?>"/>
	<input type="hidden" name="billingAddress.country" value="<?=$shopperInfo["billing"]["billingAddress.country"] ?>"/>
	<input type="hidden" name="billingAddressType" value="<?=$shopperInfo["billing"]["billingAddressType"] ?>"/>
	
	<!-- Delivery address -->
	<input type="hidden" name="deliveryAddress.street" value="<?=$shopperInfo["delivery"]["deliveryAddress.street"] ?>"/>
	<input type="hidden" name="deliveryAddress.houseNumberOrName" value="<?=$shopperInfo["delivery"]["deliveryAddress.houseNumberOrName"] ?>"/>
	<input type="hidden" name="deliveryAddress.city" value="<?=$shopperInfo["delivery"]["deliveryAddress.city"] ?>"/>
	<input type="hidden" name="deliveryAddress.postalCode" value="<?=$shopperInfo["delivery"]["deliveryAddress.postalCode"] ?>"/>
	<input type="hidden" name="deliveryAddress.stateOrProvince" value="<?=$shopperInfo["delivery"]["deliveryAddress.stateOrProvince"] ?>"/>
	<input type="hidden" name="deliveryAddress.country" value="<?=$shopperInfo["delivery"]["deliveryAddress.country"] ?>"/>
	<input type="hidden" name="deliveryAddressType" value="<?=$shopperInfo["delivery"]["deliveryAddressType"] ?>"/>
	
	<!-- Shopper -->
	<input type="hidden" name="shopper.firstName" value="<?=$shopperInfo["shopper"]["shopper.firstName"] ?>"/>
	<input type="hidden" name="shopper.infix" value="<?=$shopperInfo["shopper"]["shopper.infix"] ?>"/>
	<input type="hidden" name="shopper.lastName" value="<?=$shopperInfo["shopper"]["shopper.lastName"] ?>"/>
	<input type="hidden" name="shopper.gender" value="<?=$shopperInfo["shopper"]["shopper.gender"] ?>"/>
	<input type="hidden" name="shopper.dateOfBirthDayOfMonth" value="<?=$shopperInfo["shopper"]["shopper.dateOfBirthDayOfMonth"] ?>"/>
	<input type="hidden" name="shopper.dateOfBirthMonth" value="<?=$shopperInfo["shopper"]["shopper.dateOfBirthMonth"] ?>"/>
	<input type="hidden" name="shopper.dateOfBirthYear" value="<?=$shopperInfo["shopper"]["shopper.dateOfBirthYear"] ?>"/>
	<input type="hidden" name="shopper.telephoneNumber" value="<?=$shopperInfo["shopper"]["shopper.telephoneNumber"] ?>"/>
	<input type="hidden" name="shopperType" value="<?=$shopperInfo["shopper"]["shopperType"] ?>"/>
		
	<!-- Signatures -->
	<input type="hidden" name="billingSig" value="<?=$billingSig ?>"/>
	<input type="hidden" name="deliveryAddressSig" value="<?=$deliveryAddressSig ?>"/>
	<input type="hidden" name="shopperSig" value="<?=$shopperSig ?>"/>
	<input type="hidden" name="merchantSig" value="<?=$merchantSig ?>"/>
	
	<input type="submit" value="Create payment" />
</form>
