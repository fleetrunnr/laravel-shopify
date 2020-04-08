<?php

namespace FleetRunnr\ShopifyApp\Http\Controllers;

use Illuminate\Routing\Controller;
use FleetRunnr\ShopifyApp\Traits\BillingController as BillingControllerTrait;

/**
 * Responsible for billing a shop for plans and usage charges.
 */
class BillingController extends Controller
{
    use BillingControllerTrait;
}
