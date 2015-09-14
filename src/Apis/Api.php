<?php
namespace IreIsaac\Mws\Apis;

use IreIsaac\Mws\Mws;
use IreIsaac\Mws\Collection;

abstract class Api
{
	public function client($endpoint = 'https://mws.amazonservices.com')
	{
		$collection = new Collection();

        return new Mws($collection, $endpoint);
	}

	protected function cleanQuery(array $query, array $allowed)
	{
		$query = collect($query)->transform(function($item) {
			if ($item instanceOf \Carbon\Carbon) {
				$item = $item->toIso8601String();
			}
			return $item;
		})->flip()->transform(function($item) {
			return studly_case($item);			
		})->filter(function($item) use ($allowed) {
			return in_array($item, $allowed);
		})->flip()->toArray();

		return $query;
	}
}