<?php
namespace IreIsaac\Mws;

use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
	
	public function __construct($items = null)
	{
		if(is_null($items)) {
			return parent::__construct(config('amazon.mws'));
		}

		return parent::__construct($items);
	}

	public function paths()
	{
		return new static($this->get('paths'));
	}

	public function versions()
	{
		return new static($this->get('version'));
	}

	public function version($path)
	{
		return $this->versions()->get($path);
	}

	public function path($action)
	{
		$action = studly_case($action);

		$path = $this->paths()->filter(function($actions) use ($action) {
			return in_array($action, $actions);
		});
		
		return $path->keys()->first();
	}

	public function actions()
	{
		return $this->paths()->flatten()->toArray();
	}
}