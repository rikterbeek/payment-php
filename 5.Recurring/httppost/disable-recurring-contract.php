<?php
/**
 * Disable recurring contract
 * 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	5.Recurring/httppost/disable-recurring-contract.php 
 * @author	Created by Adyen Payments
 */
 
 $request = array(
    "action" => "Recurring.disable",
    "disableRequest.merchantAccount" => "YourMerchantAccount", 
    "disableRequest.shopperReference" => "TheShopperreference", 
    "disableRequest.recurringDetailReference" => "TheReferenceToTheContract", 
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
	 * The response will be a result object with a single field response. If a single detail was 
	 * disabled the value of this field will be [detail-successfully-disabled] or, if all 
	 * details are disabled, the value is [all-details-successfully-disabled].
	 */
	 
 	parse_str($result,$result);
    print_r(($result));
 }
 
 curl_close($ch);