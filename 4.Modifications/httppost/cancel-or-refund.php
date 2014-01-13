<?php
/**
 * Cancel or Refund a Payment
 * 
 * If you do not know if the payment is captured but you want to reverse 
 * the authorisation you can send a modification request to the cancelOrRefund action 
 * This file shows how a payment can be cancelled or refunded by a 
 * modification request using HTTP Post. 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link    https://github.com/JessePiscaer/payment-php/tree/master/4.Modificaitons/httppost/cancel-or-refund.php 
 * @author  Created by Adyen Payments
 */
  
 /**
  * - action: In this case, it's the capture payment: Payment.cancelorrefund
  * - merchantAccount: The merchant account the payment was processed with.
  * - originalReference: This is the pspReference that was assigned to the authorisation
  */
   
 $request = array(
    "action" => "Payment.cancelorrefund",
    "modificationRequest.merchantAccount" => "YourMerchantAccount",
    "modificationRequest.originalReference" => "PspReferenceOfTheAuthorisedPayment",
 ); 
  
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/adapter/httppost");
 curl_setopt($ch, CURLOPT_HEADER, false);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " .base64_encode("YourWSUser".":"."YourWSUserPassword"))); 
 curl_setopt($ch, CURLOPT_POST,count($fields));
 curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
  
 $result = curl_exec($ch);
  
 if($result === false)
    echo "Error: " . curl_error($ch);
 else{
     
     
     
    print_r($result);
 }
 curl_close($ch);
