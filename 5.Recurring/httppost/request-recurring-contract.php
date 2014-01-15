<?php
/**
 * Request recurring contract details 
 * 
 * 
 * Please note: using our API requires a web service user. 
 * Typically: ws@Company.YourCompanyCode
 *  
 * @link	5.Recurring/httppost/request-recurring-contract.php 
 * @author	Created by Adyen Payments
 */
 
 $request = array(
    "action" => "Recurring.listRecurringDetails",
    "recurringDetailsRequest.merchantAccount" => "YourMerchantAccount", 
    "recurringDetailsRequest.shopperReference" => "TheShopperreference", 
    "recurringDetailsRequest.recurring.contract" => "TheReferenceToTheContract", 
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
	 * The response will be a result with a list of zero or more details containing the following:
	 * - recurringDetailReference: The reference the details are stored under.
	 * - variant: The payment method (e.g. mc, visa, elv, ideal, paypal)
	 * - creationDate: The date when the recurring details were created.
	 * 
	 * The recurring contracts are stored in the same object types as you would have 
	 * submitted in the initial payment. 
	 */
	 
 	parse_str($result,$result);
    print_r(($result));
 }
 
 curl_close($ch);