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
  - httppost
    - notification-server.php           : Receive our notifications using HTTP Post;
  - soap
    - notification-server.php           : Receive our notification using SOAP;
4.Modifications  
  - httppost
    - cancel-or-refund.php              : Cancel or refund a payment using HTTP Post;
    - cancel.php                        : Cancel a payment using HTTP Post;
    - capture.php                       : Capture a payment using HTTP Post;
    - refund.php                        : Request a refund using HTTP Post;
  - soap
    - cancel-or-refund.php              : Cancel or refund a payment using SOAP;
    - cancel-soap.php                   : Cancel a payment using SOAP;
    - capture-soap.php                  : Capture a payment using SOAP;
    - refund-soap.php                   : Request a refund using SOAP;
5.Recurring
  - request-recurring-contract.php      : Request a recurring contact for a shopper;
  - disable-recurring-contract.php      : Disable a recurring contract for a shopper;
```
## Manuals
The code examples are based on our Integration and API manual which provides rich information on how our platform works. Please find our manuals on [support.adyen.com](support.adyen.com). 

## Support
If you do have any suggestions or questions regarding the code examples please send an e-mail to github@adyen.com.
