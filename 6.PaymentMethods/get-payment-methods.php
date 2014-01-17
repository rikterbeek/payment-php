<?php
/**
 * Get Payment Methods
 *
 * Optionally the payment method selection page can be skipped, so the shopper 
 * starts directly on the payment details entry page. This is done by calling 
 * details.shtml instead of select.shtml. A further parameter, brandCode, 
 * should be supplied with the payment method chosen (see Payment Methods section 
 * for more details, but note that the group values are not valid). 
 * 
 * The directory service can also be used to request which payment methods 
 * are available for the shopper on your specific merchant account. 
 * This is done by calling directory.shtml with a normal payment request. 
 * This file provides a code example showing how to retreive the 
 * payment methods enabled for the specified merchant account. 
 * 
 * Please note that the countryCode field is mandatory to receive 
 * back the correct payment methods. 
 */
 require_once "../lib/HMAC.php";
 
 /**
  * Payment Request
  * The following fields are required for the directory 
  * service. 
  */
 $request = array(
	"paymentAmount" => "0",
	"currencyCode" => "EUR",
	"merchantReference" => "Request payment methods",
	"skinCode" => "YourSkinCode",
	"merchantAccount" => "YourMerchantAccount",
	"sessionValidity" => date("c",strtotime("+1 days")),
	"countryCode" => "NL",
	"merchantSig" => "",
 );	
 
 // HMAC Key is a shared secret KEY used to encrypt the signature. Set up the HMAC 
 // key: Adyen Test CA >> Skins >> Choose your Skin >> Edit Tab >> Edit HMAC key for Test and Live 
 $hmacKey = "YourHmacSecretKey";
 $cryptHMAC = new Crypt_HMAC($hmacKey, "sha1");
 $request["merchantSig"] = base64_encode(pack("H*",$cryptHMAC->hash(
	$request["paymentAmount"] . $request["currencyCode"] . $request["merchantReference"] . 
	$request["skinCode"] .  $request["merchantAccount"] . $request["sessionValidity"]
 )));

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://test.adyen.com/hpp/directory.shtml");
 curl_setopt($ch, CURLOPT_HEADER, false);
 curl_setopt($ch, CURLOPT_POST,count($request));
 curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));
 
 $result = curl_exec($ch);
 
 if($result === false)
	echo "Error: " . curl_error($ch);
 else{
	/**
	 * The $result contains a JSON array containing
	 * the available payment methods for the merchant account.
	 */ 
	print_r($result);
 }
 
 curl_close($ch);
