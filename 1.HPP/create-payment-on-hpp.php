<?php
/**
 * Create Payment On Hosted Payment Page (HPP)
 * 
 * The Adyen Hosted Payment Pages (HPPs) provide a flexible, secure 
 * and easy way to allow shoppers to pay for goods or services. By 
 * submitting the form generated by this file to our HPP a payment
 * will be created for the shopper.  
 * 
 * @link	1.HPP/create-payment-on-hpp.php 
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
  * $orderData 			: A fragment of HTML/text that will be displayed on the HPP (optional)
  * $countryCode		: Country code according to ISO_3166-1_alpha-2 standard  (optional)
  * $shopperEmail		: The e-mailaddress of the shopper (optional)
  * $shopperReference	: The shopper reference, i.e. the shopper ID (optional)
  * $allowedMethods		: Allowed payment methods separeted with a , i.e. "ideal,mc,visa" (optional)
  * $blockedMethods		: Blocked payment methods separeted with a , i.e. "ideal,mc,visa" (optional)
  * $offset				: Numeric value that will be added to the fraud score (optional)
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
  $allowedMethods = ""; 
  $blockedMethods = ""; 
  $offset = ""; 
  
  /**
   * Signing the form
   * 
   * The merchant signature is used by Adyen to verify if the posted data is not
   * altered by the shopper. The signature must be encrypted according to the procedure below.
   * For this code example we use HMAC Pear (http://pear.php.net/package/Crypt_HMAC/download)
   * 
   * Please note: the signature does contain more variables, in this example
   * they are NOT required since they are empty. Please have a look at the
   * advanced HPP example for a comprehensive overview on what should be part of the signature.
   */ 
  require_once "../lib/HMAC.php";
  
  // HMAC Key is a shared secret KEY used to encrypt the signature. Set up the HMAC 
  // key: Adyen Test CA >> Skins >> Choose your Skin >> Edit Tab >> Edit HMAC key for Test and Live 
  $hmacKey = "YourHmacSecretKey";
  $cryptHMAC = new Crypt_HMAC($hmacKey, "sha1");
  
  $merchantSig = base64_encode(pack("H*",$cryptHMAC->hash(
	$paymentAmount . $currencyCode . $shipBeforeDate . $merchantReference . $skinCode . $merchantAccount . 
	$sessionValidity . $shopperEmail . $shopperReference . $allowedMethods . $blockedMethods . $offset
  ))); 
?>
<form method="GET" action="https://test.adyen.com/hpp/pay.shtml" target="_blank">
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
	<input type="hidden" name="allowedMethods" value="<?=$allowedMethods ?>"/>
	<input type="hidden" name="blockedMethods" value="<?=$blockedMethods ?>"/>
	<input type="hidden" name="offset" value="<?=$offset ?>"/>
	<input type="hidden" name="merchantSig" value="<?=$merchantSig ?>"/>	
	<input type="submit" value="Create payment" />
</form>
