<?php
namespace IreIsaac\Mws;

use Exception;
use GuzzleHttp\Client;
use IreIsaac\Mws\Signature;
use IreIsaac\Mws\Collection;

class Mws extends Client
{
	protected $collection;

	protected $operations;

	public function __construct($collection, $endpoint)
	{
		parent::__construct(['base_url' => $endpoint]);
		
		$this->collection = $collection;
	}

	/**
	 * Checks to see if the operation requested exists
	 * @param  string $action action being requested
	 * @return boolean
	 */
	public function actionIsValid($action)
	{
		$action = studly_case($action);

		if (in_array($action, $this->collection->actions())) {
			return true;
		}

		throw new Exception("The amazon action: \"{$action}\" does not exist", 1);
	}

	/**
	 * using an action, also refered to as an operation, 
	 * we can easily find the correct mws path and version
	 * @param  string $action
	 * @return array  containing action, path, version
	 */
	public function getParams($action)
	{
		$action  = studly_case($action);
		$path    = $this->collection->path($action);
		$version = $this->collection->version($path);

		return [
			'action'  => $action,
			'path'	  => $path,
			'version' => $version
		];
	}

	/**
	 * build a request to MWS
	 * @param  string $action    MWS operation
	 * @param  array  $query     assosiative array of query params
	 * @param  string $file      path to a file if being attached
	 * @param  array  $options   other optional options ex. Headers, auth
	 * @return GuzzleHttp\Message\Request $request
	 */
	public function request($action, $query = [], $file = null, $options = [])
	{
		if ($this->actionIsValid($action)) {
			$params = $this->getParams($action);
		}

		$query = $query + [
			'Action'  => $params['action'],
			'Version' => $params['version']
		];

		$request = $this->createRequest('POST', $params['path'], ['query' => $query]);

		return $request = Signature::sign($request);
	}

	/**
	 * Magic method to help make calling operation easier
	 * @param  string $name operation name
	 * @param  array $args query params for a request
	 * @return GuzzleHttp\Message\Response  $response
	 */
	public function __call($name, $args)
	{
		if(empty($args)) {
			/**
			 * There are only a few operations that do not require
			 * any arguments. I am not sure how to properly handle when a request
			 * that requires params is attempted with no params....????
			 */
			return $this->send($this->api($name));
		}
		
		return $response = $this->send($this->api($name, $args[0]));
	}
}