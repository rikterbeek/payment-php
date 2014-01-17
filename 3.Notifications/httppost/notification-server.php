<?php
/**
 * Receive notifcations from Adyen using HTTP Post
 * 
 * Whenever a payment is made, a modification is processed or a report is
 * available we will notify you. The notifications tell you for instance if
 * an authorisation was performed successfully. 
 * Notifications should be used to keep your backoffice systems up to date with
 * the status of each payment and modification. Notifications are sent 
 * using a SOAP call or using HTTP POST to a server of your choice. 
 * This file describes how HTTP Post notifcations can be received in PHP.
 *  
 * @link	3.Notifications/httppost/notification_server.php 
 * @author	Created by Adyen
 */
 
/**
 * The variabele $_POST contains an array including 
 * the following keys.
 * 
 * $_POST['currency']
 * $_POST['value']
 * $_POST['eventCode']
 * $_POST['eventDate']
 * $_POST['merchantAccountCode']
 * $_POST['merchantReference']
 * $_POST['originalReference']
 * $_POST['pspReference']
 * $_POST['reason']
 * $_POST['success']
 * $_POST['paymentMethod']
 * $_POST['operations']
 * $_POST['additionalData']
 * 
 * 
 * We recommend you to handle the notifications based on the
 * eventCode types available, please refer to the integration
 * manual for a comprehensive list. For debug purposes we also
 * recommend you to store the notification itself.
 */

 switch($_POST['eventCode']){
	
	case 'AUTHORISATION':
			// Handle AUTHORISATION notification.
			// Confirms that the payment was authorised successfully. 
		break;
		
	case 'CANCELLATION':
			// Handle CANCELLATION notification.
			// Confirms that the payment was cancelled successfully. 
		break;
		
	case 'REFUND':
			// Handle REFUND notification.
			// Confirms that the payment was refunded successfully. 
		break;
		
	case 'CANCEL_OR_REFUND':
			// Handle CANCEL_OR_REFUND notification.
			// Confirms that the payment was refunded or cancelled successfully. 
		break;
		
	case 'CAPTURE':
			// Handle CAPTURE notification.
			// Confirms that the payment was successfully captured. 
		break;
		
	case 'REFUNDED_REVERSED':
			// Handle REFUNDED_REVERSED notification.
			// Tells you that the refund for this payment was successfully reversed. 
		break;
		
	case 'CAPTURE_FAILED':
			// Handle AUTHORISATION notification.
			// Tells you that the capture on the authorised payment failed. 
		break;
				
	case 'REQUEST_FOR_INFORMATION':
			// Handle REQUEST_FOR_INFORMATION notification.
			// When there is a dispute you are requested to provide information for the specific payment. 
		break;
		
	case 'NOTIFICATION_OF_CHARGEBACK':
			// Handle NOTIFICATION_OF_CHARGEBACK notification.
			// Let's you know that someone has issued a chargeback
		break;
		
	case 'CHARGEBACK':
			// Handle CHARGEBACK notification.
			// Let's you know that money for this payment was chargebacked. 
		break;
	
	case 'CHARGEBACK_REVERSED':
			// Handle CHARGEBACK_REVERSED notification.
			// Notifies you that the chargeback for this payment was reversed. 
		break;
	
	case 'REPORT_AVAILABLE':
			// Handle REPORT_AVAILABLE notification.
			// There is a new report available, the URL of the report is in the "reason" field.
		break;
 }
		
 
 /**
  * Returning [accepted], please make sure you always
  * return [accepted] to us, this is essential to let us 
  * know that you received the notification. If we do NOT receive
  * [accepted] we try to send the notification again which
  * will put all other notification in a queue.
  */
 print "[accepted]";

 
 


