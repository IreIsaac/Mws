<?php
namespace IreIsaac\Mws\Apis;

use Carbon\Carbon;
use GuzzleHttp\Pool;
use IreIsaac\Mws\Apis\Api;

class Order extends Api
{
	protected $status = [
		'PendingAvailability',
		'Pending',
		'Unshipped',
		'PartiallyShipped',
		'Shipped',
		'InvoiceUnconfirmed',
		'Canceled',
		'Unfulfillable',
	];

	protected $options = [
		'CreatedAfter', 
		'CreatedBefore', 
		'LastUpdatedAfter', 
		'LastUpdatedBefore', 
		'OrderStatus',
		'OrderStatus.Status.1',
		'OrderStatus.Status.2',
		'OrderStatus.Status.3',
		'OrderStatus.Status.4',
		'OrderStatus.Status.5',
		'FulfillmentChannel',
		'PaymentMethod',
		'BuyerEmail',
		'SellerOrderId',
		'TFMShipmentStatus',
	];

	/**
	 * List orders, default query will return all orders from last month
	 * @param  array  $query query params
	 * @return \SimpleXMLElement $response
	 */
	public function listOrders($query = []) 
	{
		if (! array_key_exists('CreatedAfter', $query) && ! array_keys_exists('LastUpdatedAfter', $query)) {
			$query['CreatedAfter'] = Carbon::now()->subMonth()->toIso8601String();
		}

		$request = $this->client->request('ListOrders', $query);

		$response = $this->client->send($request);

		return $response->xml()->ListOrdersResult;
	}

	/**
	 * Easily retrieve all unshipped orders
	 * @return \SimpleXMLElement $response
	 */
	public function unshipped()
	{
		$request = $this->client->request('ListOrders', [
			'CreatedAfter'         => Carbon::now()->subMonth()->toIso8601String(),
			'OrderStatus.Status.1' => 'Unshipped', 
			'OrderStatus.Status.2' => 'PartiallyShipped'
		]);

		$response = $this->client->send($request);

		return $response->xml()->ListOrdersResult;
	}

	/**
	 * List Orders by next token
	 * @param  string $token token specified by list orders
	 * @return \SimpleXMLElement $response
	 */
	public function listOrdersByNextToken($token)
	{
		$request = $this->client->request('ListOrdersByNextToken', [
			'NextToken' => $token
		]);

		$response = $this->client->send($request);

		return $response->xml()->ListOrdersByNextTokenResult;
	}

	/**
	 * get all info related to an order
	 * same as calling find($orderId)
	 * @param  string $orderId
	 * @return \SimpleXMLElement $response
	 */
	public function getOrder($orderId)
	{
		return $this->find($orderId);
	}

	/**
	 * get all info related to an order
	 * same as calling find($orderId)
	 * @param  string $orderId
	 * @return \SimpleXMLElement $response
	 */
	public function find($orderId)
	{
		$request = $this->client->request('GetOrder', [
			'AmazonOrderId.Id.1' => $orderId
		]);

		$response = $this->client->send($request);

		return $response->xml()->GetOrderResult;
	}

	/**
	 * Find the items related to a specific order
	 * @param  string $orderId
	 * @return \SimpleXMLElement $response
	 */
	public function listOrderItems($orderId)
	{
		$request = $this->client->request('ListOrderItems', [
			'AmazonOrderId' => $orderId
		]);

		$response = $this->client->send($request);

		return $response->xml()->ListOrderItemsResult;
	}

	/**
	 * Alias for listOrderItems
	 * @param  string $orderId
	 * @return \SimpleXMLElement $response
	 */
	public function items($orderId)
	{
		return $this->listOrderItems($orderId);
	}

	/**
	 * List Order Items By Next Token when too many
	 * items returned from listOrderItems($id)
	 * @param string $token
	 * @return \SimpleXMLElement $response
	 */
	public function listOrderItemsByNextToken($token)
	{
		$request = $this->client->request('listOrderItemsByNextToken',[
			'NextToken' => $token
		]);

		$response = $this->client->send($request);

		return $response->xml()->ListOrderItemsByNextTokenResult;
	}
}