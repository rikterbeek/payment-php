Adyen PHP Integration
==============
Code examples in this reposity help you integrate with the Adyen platform using PHP. Please go through the code examples 
and read the brief explanation on how this repository is structured.

## Code structure
```
1.HPP
  - create-payment-on-hpp.php           : Simple form creating a payment on our HPP;
  - create-payment-on-hpp-advanced.php  : Advanced form creating a payment on our HPP;
2. API
  - create-payment-api.php              : Create an payment via our API;
3.Notifications
  - notification_server-soap.php        : Receive our notifications using SOAP;
  - notification_server-httppost.php    : Receive our notification using HTTP Post;
4.Modifications  
  - cancel-soap.php                     : Cancel a payment using SOAP;
  - cancel-httppost.php                 : Cancel a payment using HTTP Post;
  - capture-soap.php                    : Capture a payment using SOAP;
  - capture-httppost.php                : Capture a payment using HTTP Post;
  - refund-soap.php                     : Request a refund using SOAP;
  - refund-httppost.php                 : Request a refund using HTTP Post;
5.Recurring
  - request-recurring-contract.php      : Request a recurring contact for a shopper;
  - disable-recurring-contract.php      : Disable a recurring contract for a shopper;\
  - [support.adyen.com](support.adyen.com)
```
## Manuals
The code examples are based on our Integration and API manual which provides rich information on how our platform works. Please find our manuals on [support.adyen.com](support.adyen.com). 

## Support
If you do have any suggestions or questions regarding the code examples please send an e-mail to github@adyen.com.
