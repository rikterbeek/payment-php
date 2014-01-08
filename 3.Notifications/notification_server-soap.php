<?php
/**
 * Receive notifcations from Adyen ysing SOAP
 * 
 * Whenever a payment is made or a modification is processed we will 
 * notify you of the event and whether or not it was performed successfully. 
 * Notifications should be used to keep your backoffice systems up to date with
 * the status of each payment and modification. Notifications are sent 
 * using a SOAP call or using HTTP POST parameters to a server of your choice. 
 * This file describes how SOAP notifcations can be received in PHP
 *  
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/3.Notifications/notification_server-soap.php 
 * @author	Created by Adyen Payments
 */
 
 ini_set("soap.wsdl_cache_enabled", "0"); 
 
 /**
  * Create a SoapServer which implements the SOAP protocol used by Adyen and 
  * implement the sendNotification action in order to call a function handling
  * the notification.
  */
 $server = new SoapServer("https://ca-test.adyen.com/ca/services/Notification?wsdl"); 
 $server->addFunction("sendNotification"); 
 $server->handle();
 
 
 function sendNotification($request) {
	
	/*
	 * In SOAP it's possible that we send you multiple notifications
	 * in one request. First we verify if the request the SOAP envelopes.
	 */
	if(isset($request->notification->notificationItems) && count($request->notification->notificationItems) >0)
		foreach($request->notification->notificationItems as $notificationRequestItem){
			
			/*
			 * Each $notificationRequestItem contains the following fields:
			 * $notificationRequestItem->amount->currency
			 * $notificationRequestItem->amount->value
			 * $notificationRequestItem->eventCode
			 * $notificationRequestItem->eventDate
			 * $notificationRequestItem->merchantAccountCode
			 * $notificationRequestItem->merchantReference
			 * $notificationRequestItem->originalReference
			 * $notificationRequestItem->pspReference
			 * $notificationRequestItem->reason
			 * $notificationRequestItem->success
			 * $notificationRequestItem->paymentMethod
			 * $notificationRequestItem->operations
			 * $notificationRequestItem->additionalData
			 * 
			 * 
			 * We reccomend you to handle the notifications based on the
			 * eventCode types available, please refer to the integration
			 * manual for a comprehensive list. For debug purposes we also
			 * recommend you to store the notification itself.
			 */
			
			switch($notificationRequestItem->eventCode){
				
				case 'AUTHORISATION':
						// Handle AUTHORISATION notification.
					break;
					
				case 'CANCELLATION':
						// Handle CANCELLATION notification.
					break;
					
				case 'REFUND':
						// Handle REFUND notification.
					break;
					
				case 'CANCEL_OR_REFUND':
						// Handle CANCEL_OR_REFUND notification.
					break;
					
				case 'CAPTURE':
						// Handle CAPTURE notification.
					break;
					
				case 'REFUNDED_REVERSED':
						// Handle REFUNDED_REVERSED notification.
					break;
					
				case 'CAPTURE_FAILED':
						// Handle AUTHORISATION notification.
					break;
					
				case 'CAPTURE_FAILED':
						// Handle AUTHORISATION notification.
					break;
					
				case 'REQUEST_FOR_INFORMATION':
						// Handle REQUEST_FOR_INFORMATION notification.
					break;
					
				case 'NOTIFICATION_OF_CHARGEBACK':
						// Handle NOTIFICATION_OF_CHARGEBACK notification.
					break;
			
				case 'ADVICE_OF_DEBIT':
						// Handle ADVICE_OF_DEBIT notification.
					break;
					
				case 'CHARGEBACK':
						// Handle CHARGEBACK notification.
					break;
				
				case 'CHARGEBACK_REVERSED':
						// Handle CHARGEBACK_REVERSED notification.
					break;
				
				case 'REPORT_AVAILABLE':
						// Handle REPORT_AVAILABLE notification.
					break;
			}
		}
			
	 
	 /**
	  * Returning [accepted], please make sure you always
	  * return [accepted] to us, this is essential to let us 
	  * know that you received the notification. If we do NOT receive
	  * [accepted] we try to send the notification again which
	  * will put all other notification in a que.
	  */
	 return array("notificationResponse" => "[accepted]");
 } 
 
 


