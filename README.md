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
Laravel Example:
--------------------------
```php
use Mws;

public function search($query)
{
	$response = Mws::listMatchingProducts(['Query' => 'some product on amazon']);

	return $response->xml();
}
```
