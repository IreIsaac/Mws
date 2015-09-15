<?php
namespace IreIsaac\Mws\Apis;

use Carbon\Carbon;
use GuzzleHttp\Pool;
use IreIsaac\Mws\Apis\Api;

class Product extends Api
{
	/**
	 * returns a list of products and their attributes, 
	 * ordered by relevancy, based on a search query that you specify
	 * @param  string $query
	 * @return \SimpleXMLElement $response
	 */
    public function listMatchingProducts($query)
    {
        $request = $this->client->request('ListMatchingProducts', [
            'Query' => $query
        ]);

        $response = $this->client->send($request);

        return $response->xml()->ListMatchingProductsResult;
    }

    /**
     * use a specifig idtype to find a product
     * @param string $idType ASIN, GCID, SellerSKU, UPC, EAN, ISBN, or JAN
     * @param string|array $id
     */
    public function getMatchingProductForId($idType, $id)
    {
        if (! is_array($id)) {
            $id = [$id];
        }

        $queryIds = $this->buildIdList($id, 'IdList.Id');
        $query = $queryIds + ['IdType' => $idType];

        return $this->send('GetMatchingProductForId', $query);
    }

    /**
     *  the current competitive pricing of a product,
     *  based on the SellerSKU and MarketplaceId 
     *  that you specify
     *  @param string|array $sku
     *  @return \SimpleXMLElement $response
     */
    public function getCompetitivePricingForSKU($sku)
    {
    	if (! is_array($sku)) {
    		$sku = [$sku];
    	}
    	$skuList = $this->buildIdList($sku, 'SellerSKUList.SellerSKU', 20);

    	return $this->send('GetCompetitivePricingForSKU', $skuList);
    }

    public function getCompetitivePricingForASIN($asin)
    {
    	if (! is_array($asin)) {
    		$asin = [$asin];
    	}
    	$asinList = $this->buildIdList($asin, 'ASINList.ASIN', 20);

    	return $this->send('GetCompetitivePricingForASIN', $asinList);
    }

    // public function getLowestOfferListingsForSKU($sku)
    // {
    	
    // }

    // public function getLowestOfferListingsForASIN()
    // {
    // }

    // public function getMyPriceForSKU()
    // {
    // }

    // public function getMyPriceForASIN()
    // {
    // }

    // public function getProductCategoriesForSKU()
    // {
    // }

    // public function getProductCategoriesForASIN()
    // {
    // }

    private function send($operation, $query)
    {
    	$request = $this->client->request($operation, $query);
    	$response = $this->client->send($request)->xml();

    	return $this->collectProducts($response);
    }

    private function buildIdList(array $ids, $prepend, $limit = 5)
    {
        $list = [];
        $count = 1;

        foreach (array_chunk($ids, $limit)[0] as $id) {
            $list[$prepend . '.' . $count] = $id;
            $count++;
        }

        return $list;
    }

    private function collectProducts($products)
    {
    	$results = [];

    	foreach($products->children() as $product) {
    		if($product->getName() != 'ResponseMetadata') {
    			$results[] = $product;
    		}
    	}

    	return $results;
    }

}
