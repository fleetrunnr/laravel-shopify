<?php

namespace FleetRunnr\ShopifyApp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use function FleetRunnr\ShopifyApp\createHmac;
use FleetRunnr\ShopifyApp\Services\ShopSession;
use FleetRunnr\ShopifyApp\Traits\ConfigAccessible;
use FleetRunnr\ShopifyApp\Objects\Values\ShopDomain;
use FleetRunnr\ShopifyApp\Objects\Values\NullShopDomain;
use FleetRunnr\ShopifyApp\Objects\Values\NullableShopDomain;

/**
 * Responsible for ensuring a proper app proxy request.
 */
class AuthProxy
{
    use ConfigAccessible;

    /**
     * Shop session helper.
     *
     * @var ShopSession
     */
    protected $shopSession;

    /**
     * Constructor.
     *
     * @param ShopSession $shopSession Shop session helper.
     *
     * @return self
     */
    public function __construct(ShopSession $shopSession)
    {
        $this->shopSession = $shopSession;
    }

    /**
     * Handle an incoming request to ensure it is valid.
     *
     * @param Request  $request The request object.
     * @param \Closure $next    The next action.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Grab the query parameters we need
        $query = $request->query->all();
        $signature = isset($query['signature']) ? $query['signature'] : null;
        $shop = NullableShopDomain::fromNative($query['shop'] ?? null);

        if (isset($query['signature'])) {
            // Remove signature since its not part of the signature calculation
            unset($query['signature']);
        }

        // Get the api secret based on app mode
        if($this->getConfig('custom_app_mode')) {
            // Get the user model
            $userModel = $this->getConfig('user_model');

            // Try to get the api secret from shop user
            $shopUser = $userModel::where('name', $query['shop'])->first();
            if(!$shopUser || ($shopUser && !$shopUser->api_secret)) {
                // Missing shop API secret
                return Response::make('Invalid shop api credentials.', 401);
            }

            $apiSecret = $shopUser->api_secret;
        } 
        else {
            $apiSecret = $this->getConfig('api_secret');
        }

        // Build a local signature
        $signatureLocal = createHmac(['data' => $query, 'buildQuery' => true], $apiSecret);
        if ($signature !== $signatureLocal || $shop->isNull()) {
            // Issue with HMAC or missing shop header
            return Response::make('Invalid proxy signature.', 401);
        }

        // Login the shop
        $this->shopSession->make($shop);

        // All good, process proxy request
        return $next($request);
    }
}
