<?php
/**
 * Create Payment On Hosted Payment Page (HPP)
 * 
 * The Adyen Hosted Payment Pages (HPPs) provide a flexible, secure 
 * and easy way to allow customers to pay for goods or services. By 
 * submitting the form generated by this file to our HPP a payment
 * will be created for the shopper.  
 * 
 * @link		https://www.adyen.com Adyen Payments
 * @author		Created by Adyen Payments
 */
 
 /**
  * Defining variables
  * The HPP requires certain variables to be posted in order to create
  * a payment possibility for the shopper. 	 
  * 
  * The variables that you can post to the HPP are the following:
  * 
  * $merchantReference	: The merchant reference is your reference for the payment;
  * $paymentAmount		: Amount specified in minor units $1,00 = 100
  * $currencyCode		: The three-letter capitalised ISO currency code to pay in
  * $shipBeforeDate		: YYYY-MM-DD.
  * $skinCode			: Your skin code
  * $merchantAccount	: Your merchant account
  * $sessionValidity	: YYYY-MM-DDThh:mm:ssTZD
  * $shopperLocale		: A combination of language code and country code to specify the language used in th e session
  * $orderData			: A fragment of HTML/text that will be displayed on the HPP
  * $countryCode		: Country code according to ISO_3166-1_alpha-2 standard  
  * $shopperEmail		: The e-mailaddress of the shopper
  * $shopperReference	: The shopper reference, i.e. the shopper ID
  * $allowedMethods		: Allowed payment methods separeted with a , i.e. "ideal,mc,visa" 
  * $blockedMethods		: Blocked payment methods separeted with a , i.e. "ideal,mc,visa"
  * $offset				: Numeric value that will be added to the fraud score
  * $shopperStatement	: 
  * $merchantSig		: 
  */
  
  $merchantReference = 'Test payment ' . date("Y-m-d H:i:s");
  $paymentAmount = 199; 	
  $currencyCode = 'EUR';	
  $shipBeforeDate = date("Y-m-d",strtotime("+3 days")); 
  $skinCode = 'YourSkinCode';
  $skinCode = 'Iix4eLo8';
  $merchantAccount = 'YourMerchantAccount';
  $merchantAccount = 'JessePiscaerCOM';
  $sessionValidity = date("c",strtotime("+1 days")); 
  $shopperLocale = 'en_US'; 
  $orderData = base64_encode(gzencode("Orderdata to display on the HPP can be put here"));
  $countryCode = "US";
  $shopperEmail = ""; //(optional)
  $shopperReference = ""; // (optional)
  
  $allowedMethods = ""; // (optional)
  $blockedMethods = ""; // (optional)
  
  $offset = ""; // (optional)
  $shopperStatement = ""; // (optional)
  
  /**
   * Signing the form
   * 
   * The merchant signature is used by Adyen to verify if the posted data is not
   * altered by the shopper. The signature must be encrypted according to the procedure below.
   * For this code example we use HMAC Pear (http://pear.php.net/package/Crypt_HMAC/download)
   */ 
  require_once './HMAC.php';
  
  // HMAC Key is a shared secret KEY used to encrypt the signature, this can be configured in the skin. 
  $hmacKey = "123456";
  $cryptHMAC = new Crypt_HMAC($hmacKey, 'sha1');
  
  $merchantSig = base64_encode(pack('H*',$cryptHMAC->hash(
	$paymentAmount . $currencyCode . $shipBeforeDate . $merchantReference . $skinCode . $merchantAccount . 
	$sessionValidity . $shopperEmail . $shopperReference . 
	$allowedMethods . $blockedMethods . $shopperStatement . $offset
  ))); 
?>
<form method="POST" action="https://test.adyen.com/hpp/pay.shtml" target="_blank">
	<input type="text" name="merchantReference" value="<?=$merchantReference ?>"/>
	<input type="text" name="paymentAmount" value="<?=$paymentAmount ?>"/>
	<input type="text" name="currencyCode" value="<?=$currencyCode ?>"/>
	<input type="text" name="shipBeforeDate" value="<?=$shipBeforeDate ?>"/>
	<input type="text" name="skinCode" value="<?=$skinCode ?>"/>
	<input type="text" name="merchantAccount" value="<?=$merchantAccount ?>"/>
	<input type="text" name="sessionValidity" value="<?=$sessionValidity ?>"/>
	<input type="text" name="shopperLocale" value="<?=$shopperLocale ?>"/>
	<input type="text" name="orderData" value="<?=$orderData ?>"/>
	<input type="text" name="countryCode" value="<?=$countryCode ?>"/>
	<input type="text" name="shopperEmail" value="<?=$shopperEmail ?>"/>
	<input type="text" name="shopperReference" value="<?=$shopperReference ?>"/>
	<input type="text" name="allowedMethods" value="<?=$allowedMethods ?>"/>
	<input type="text" name="blockedMethods" value="<?=$blockedMethods ?>"/>
	<input type="text" name="offset" value="<?=$offset ?>"/>
	<input type="text" name="shopperStatement" value="<?=$shopperStatement ?>"/>
	<input type="text" name="merchantSig" value="<?=$merchantSig ?>"/>
	<input type="submit" value="Create payment" />
</form>
