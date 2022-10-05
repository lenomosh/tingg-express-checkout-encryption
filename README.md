# Tingg Express Checkout Envcryption
This project encrypts and returns the checkout URL used by tingg to process payments

# Set up instructions
- run `cp .env.example .env`
- Fill the .env file with the appropriate information. [More Info](https://dev-portal.tingg.africa/configure-checkout-account)
- run `composer install`
- run `php -S localhost:5000 ./CheckoutEncryption.php`
- Send a post request with the following example as json payload
```json
{
   "msisdn":"+254700000000",
   "account_number":"c1f335c7-2262-48d4-9e89-a3c3a857d602",
   "country_code":"KEN",
   "currency_code":"KES",
   "customer_email":"Adolphus1@yahoo.com",
   "customer_first_name":"Beatrice",
   "customer_last_name":"Cole",
   "merchant_transaction_id":"4ee94d2c-0f39-4aa3-bcb2-7a19567db753",
   "request_amount":"100",
   "request_description":"Ab distinctio laborum reiciendis quis.",
   "invoice_number":"4d67ae3c-385f-464c-ab32-6cd166a10e3f",
   "language_code":"en"
}
```

You can get more details from [the documentation](https://dev-portal.tingg.africa/express-checkout)