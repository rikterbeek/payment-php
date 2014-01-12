<?php
/**
 *
 *
 *
 *Optionally the payment method selection page can be skipped, so the shopper starts directly on the payment details entry page. This is done by calling details.shtml instead of select.shtml. A further parameter, brandCode, should be supplied with the payment method chosen (see Payment Methods section for more details, but note that the group values are not valid). See Appendix A for a list of possible URLs.
 
 The directory service can also be used to request which payment methods are available for the shopper on your specific merchant account. This is done by calling directory.shtml (e.g. https://test.adyen.com/hpp/directory.shtml) with a normal payment request. You will receive a JSON response with the following structure:
 
 
 Please note that the countryCode field is mandatory to receive back the correct payment methods.
 
 */
 