<?php
/**
 * Capture a Payment
 * 
 * Authorised (card) payments can be captured to charge the shopper. 
 * Payments can be automatically captured by our platform. A payment can
 * also be captured by performing an API call. In order to capture an authorised 
 * (card) payment you have to send a modification request. This file
 * shows how an authorised payment should be captured by sending 
 * a modification request using HTTP Post. 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link    https://github.com/JessePiscaer/payment-php/tree/master/4.Modifications/httppost/capture.php 
 * @author  Created by Adyen Payments
 */
  
 /**
  * - action: In this case, it's the capture payment: Payment.capture
  * - merchantAccount: The merchant account the payment was processed with.
  * - modificationAmount: The amount to capture
  *     - currency: the currency must match the original payment
  *     - amount: the value must be the same or less than the original amount
  * - originalReference: This is the pspReference that was assigned to the authorisation
  * - reference: If you wish, you can to assign your own reference or description to the modification. 
  */
   
 $request = array(
    "action" => "Payment.capture",
    "modificationRequest.merchantAccount" => "YourMerchantAccount",
    "modificationRequest.modificationAmount.currency" => "EUR",
    "modificationRequest.modificationAmount.value" => "199",
    "modificationRequest.originalReference" => "PspReferenceOfTheAuthorisedPayment",
    "modificationRequest.reference" => "YourReference"
 ); 
  
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/adapter/httppost");
 curl_setopt($ch, CURLOPT_HEADER, false);
 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 curl_setopt($ch, CURLOPT_USERPWD, "YourWSUser:YourWSUserPassword");
 curl_setopt($ch, CURLOPT_POST,count($request));
 curl_setopt($ch, CURLOPT_POSTFIELDS,$request);
  
 $result = curl_exec($ch);
  
 if($result === false)
    echo "Error: " . curl_error($ch);
 else
    print_r($result);
 
 curl_close($ch);
