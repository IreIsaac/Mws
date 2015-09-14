<?php
namespace IreIsaac\Mws\Apis;

use Carbon\Carbon;
use IreIsaac\Mws\Apis\Api;
/**
* 
*/
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
		'FulfillmentChannel',
		'PaymentMethod',
		'BuyerEmail',
		'SellerOrderId',
		'TFMShipmentStatus',
	];

	public function listOrders($query = []) 
	{
		if (empty($options)) {
			$query['CreatedAfter'] = Carbon::now()->subMonth();
		}
		$query = $this->cleanQuery($query, $this->options);

		return $this->client()->request('ListOrders', $query);
	}

	public function ListOrdersByNextToken($token)
	{

	}

	public function GetOrder($orderId)
	{

	}

	public function ListOrderItems($orderId)
	{

	}

	public function ListOrderItemsByNextToken($token)
	{

	}

	public function GetServiceStatus()
	{

	}
}