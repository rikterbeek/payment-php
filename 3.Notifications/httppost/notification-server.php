<?php
/**
 * Receive notifcations from Adyen ysing HTTP POST
 * 
 * Whenever a payment is made or a modification is processed we will 
 * notify you of the event and whether or not it was performed successfully. 
 * Notifications should be used to keep your backoffice systems up to date with
 * the status of each payment and modification. Notifications are sent 
 * using a SOAP call or using HTTP POST parameters to a server of your choice. 
 * This file describes how HTTP POST notifcations can be received in PHP. 
 *  
 * @link	https://github.com/JessePiscaer/payment-php/tree/master/3.Notifications/httppost/notification_server.php 
 * @author	Created by Adyen Payments
 */
 
 // Catch the $_POST variables.
 $notification = $_POST;
 
/**
 * The variabele $notification contains an array including 
 * the following keys.
 * 
 * $notification['currency']
 * $notification['value']
 * $notification['eventCode']
 * $notification['eventDate']
 * $notification['merchantAccountCode']
 * $notification['merchantReference']
 * $notification['originalReference']
 * $notification['pspReference']
 * $notification['reason']
 * $notification['success']
 * $notification['paymentMethod']
 * $notification['operations']
 * $notification['additionalData']
 * 
 * 
 * We reccomend you to handle the notifications based on the
 * eventCode types available, please refer to the integration
 * manual for a comprehensive list. For debug purposes we also
 * recommend you to store the notification itself.
 */

 switch($notification['eventCode']){
	
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
		
 
 /**
  * Returning [accepted], please make sure you always
  * return [accepted] to us, this is essential to let us 
  * know that you received the notification. If we do NOT receive
  * [accepted] we try to send the notification again which
  * will put all other notification in a que.
  */
 print "[accepted]";

 
 


