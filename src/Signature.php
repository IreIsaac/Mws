<?php 
namespace IreIsaac\Mws;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Message\Request;
/**
* 
*/
class Signature
{
    protected $defaults;

    public function __construct()
    {
        $this->defaults = [
            'AWSAccessKeyId'   => env('AWS_ACCESS_KEY_ID', ''),
            'MarketplaceId'    => env('MWS_MARKETPLACE_ID', ''),
            'SellerId'         => env('MWS_SELLER_ID', ''),
            'SignatureMethod'  => env('MWS_SIGNATURE_METHOD', ''),
            'SignatureVersion' => env('MWS_SIGNATURE_VERSION', ''),
            'Timestamp'        => Carbon::now()->toIso8601String(),
        ];
    }

    public function signer(Request $request)
    {
        $query = $request->getQuery();
        $query->merge($this->defaults);
        $newQuery = $query->toArray();

        if (str_contains(strtolower($request->getPath()), 'orders')) {
            $newQuery['MarketplaceId.Id.1'] = $newQuery['MarketplaceId'];
            unset($newQuery['MarketplaceId']);
        }

        ksort($newQuery, SORT_NATURAL);
        $query->replace($newQuery);

        $canonicalizedString = implode("\n", [
            $request->getMethod(),
            $request->getHost(),
            $request->getPath(),
            (string) $request->getQuery()
        ]);

        $signature = base64_encode(hash_hmac(
            'sha256',
            $canonicalizedString,
            env('MWS_SECRET_KEY'),
            true
        ));

        $request->getQuery()->set('Signature', $signature);

        return $request;
    }
    
    /**
     * Add an Mws Signature to a request
     * not the best method, but takes care of everything
     * @param  GuzzleHttp\Message\Request $request
     * @return GuzzleHttp\Message\Request $request
     */
    public static function sign(Request $request)
    {
        $signature = new static;
        $signature->signer($request);
        
        return $request;
    }
}
