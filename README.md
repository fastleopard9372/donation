# codeigniter-paypal-integration
Paypal payment gateway integration in codeigniter


add this File to parent branch:

codeigniter-paypal-integration/.htaccess

Now open .htaccess file and save the below code....

RewriteEngine On\
RewriteCond %{REQUEST_FILENAME} !-f\
RewriteCond %{REQUEST_FILENAME} !-d\
RewriteRule ^(.*)$ index.php/$1 [L]

--- To create paypal account for testing follow the belowe given steps

1. Now open URL: https://developer.paypal.com/developer/accounts/
2. Login with paypal account
3. After login in the account now click on "Accounts" on the right blue bar
4. Noew click on "Create Account" 
5. click on "Personal" then click on create
6. It will give you Test account to test your paypal.
7. Now enter you email id in "application/config/paypal.php" $config['business'] = 'Your_PayPal_Email';
8. Open your http://localhost/phpmyadmin create new database
9. Import SQL file available in "codeigniter-paypal-integration/SQL/products_payments.sql";
10.Now click the URL: http://localhost/codeigniter-paypal-integration/
