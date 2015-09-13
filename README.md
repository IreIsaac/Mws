# IreIsaac: Amazon Marketplace Web Services
package to help simplify requests to MWS. Heavily relys on GuzzleHttp.

Make sure to add the .env file in the root of your project, or add to your .env file, the following lines. There is also .env.example file included. 
```shell
MWS_SELLER_ID=
MWS_MARKETPLACE_ID=
MWS_DEVELOPER_ACCOUNT_NUMBER=
MWS_SECRET_KEY=
MWS_SIGNATURE_METHOD=
MWS_SIGNATURE_VERSION=

AWS_ACCESS_KEY_ID=
```
Installation In Laravel with Composer
--------------------------
```bash
composer require ireisaac\mws
```
```php
// in your config/app.php

'providers' => [
	...
	IreIsaac\Mws\Support\MwsServiceProvider::class,
],

'aliases' => [
	...
	'Mws'       => IreIsaac\Mws\Support\MwsFacade::class,
],
```
### DON'T FORGET
after adding the service provider, in the root of your laravel project run:
```bash
php artisan vendor:publish
```
Laravel Example:
--------------------------
The goal is to be able to call any MWS operation as a static method and pass any query params needed/wanted as an associative array. 
```php
use Mws;
use Carbon\Carbon;

public function search($query)
{
	$response = Mws::listMatchingProducts(['Query' => $query]);

	return $response->xml();
}

public function orders()
{
	// Orders from the last week
	$response = Mws::ListOrders([
		'CreatedAfter' => Carbon::now()->subWeek()->toIso8601String()
	]);

	return $response->xml();
}
```

PS: this is the first package i've made public. Any help would be great, as this is  a work  in progress. Thanks