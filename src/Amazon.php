<?php
namespace IreIsaac\Mws;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Event\ErrorEvent;
use GuzzleHttp\Exception\RequestException;
use IreIsaac\Mws\Signature;
use IreIsaac\Mws\Collection;

class Amazon extends Client
{
	protected $collection;

	public function __construct($collection, $endpoint)
	{
		parent::__construct(['base_url' => $endpoint]);
		
		$this->collection = $collection;
	}

	public function checkAction($action)
	{
		if (in_array($action, $this->collection->actions())) {
			return true;
		}

		throw new Exception("The amazon action: \"{$action}\" does not exist", 1);
		
	}

	public function __call($name, $args)
	{
		if(empty($args)){
			return $this->send($this->api($name));
		}
		
		return $this->send($this->api($name, $args[0]));
	}

	public function api($action, $query = [], $file = null, $options = [])
	{
		$action = studly_case($action);
		$this->checkAction($action);
		$path = $this->collection->path($action);
		$version = $this->collection->version($path);
		
		$query = $query + [
			'Action' => studly_case($action),
			'Version' => $version
		];

		$request = $this->createRequest('POST', $path, ['query' => $query]);

		if(! is_null($file)) {
			$this->attach($file);
		}

		Signature::sign($request);

		return $request;
	}
}