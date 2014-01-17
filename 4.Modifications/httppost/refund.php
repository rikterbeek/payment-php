<?php
/**
 * Refund a Payment using HTTP Post
 * 
 * Settled payments can be refunded by sending a modifiction request
 * to the refund action. This file shows how a settled payment 
 * can be refunded by a modification request using HTTP Post. 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
 * @link    4.Modifications/httppost/refund.php 
 * @author  Created by Adyen Payments
 */
   
 /**
  * - action: In this case, it's the capture payment: Payment.refund
  * - merchantAccount: The merchant account the payment was processed with.
  * - modificationAmount: The amount to capture
  *     - currency: the currency must match the original payment
  *     - amount: the value must be the same or less than the original amount
  * - originalReference: This is the pspReference that was assigned to the authorisation
  * - reference: If you wish, you can to assign your own reference or description to the modification. 
  */
   
 $request = array(
    "action" => "Payment.refund",
    "modificationRequest.merchantAccount" => "YourMerchantAccount",
    "modificationRequest.modificationAmount.currency" => "EUR",
    "modificationRequest.modificationAmount.value" => "199",
    "modificationRequest.originalReference" => "PspReferenceOfTheAuthorisedPayment",
 ); 
  
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/adapter/httppost");
 curl_setopt($ch, CURLOPT_HEADER, false); 
 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC  );
 curl_setopt($ch, CURLOPT_USERPWD, "YourWSUser:YourWSUserPassword");
 curl_setopt($ch, CURLOPT_POST,count($request));
 curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
 $result = curl_exec($ch);
  
 if($result === false)
    echo "Error: " . curl_error($ch);
 else{
	/**
	 * The response. You will receive a confirmation that we received your request: [refund-received]. 
	 * 
	 * Please note: The result of the capture is sent via a notification with eventCode REFUND.
	 */ 
	parse_str($result,$result);
    print_r(($result));
 }
 
 curl_close($ch);
