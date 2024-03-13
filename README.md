JYSK Newsletter Endpoint Module
The JYSK Newsletter Endpoint module provides API endpoints to manage newsletter subscriptions in Magento. It allows external systems to subscribe, check subscription status, and unsubscribe users from the newsletter.

Installation
To install the JYSK Newsletter Endpoint module, follow these steps:

Copy the contents of the JYSK/NewsletterEndpoint directory to the app/code/JYSK/NewsletterEndpoint directory of your Magento installation.

Run the following commands from the root directory of your Magento installation:

bash
Copy code
php bin/magento module:enable JYSK_NewsletterEndpoint
php bin/magento setup:upgrade
php bin/magento setup:di:compile
Flush the Magento cache:

bash
Copy code
php bin/magento cache:flush
Usage
The module provides the following API endpoints:

Subscribe by Email:

Endpoint: /rest/V1/newsletter/subscribe
Method: POST
Parameters: email (string)
Description: Subscribes a user to the newsletter using their email address.
Check Subscription Status:

Endpoint: /rest/V1/newsletter/isSubscribed
Method: GET
Parameters: email (string)
Description: Checks if a user is subscribed to the newsletter.
Unsubscribe by Email:

Endpoint: /rest/V1/newsletter/unsubscribe
Method: DELETE
Parameters: email (string)
Description: Unsubscribes a user from the newsletter using their email address.
Configuration
No additional configuration is required for this module. Ensure that the Magento REST API is enabled and configured correctly.

Support
For support or inquiries, please contact us at support@example.com.
