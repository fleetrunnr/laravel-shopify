<?php

namespace FleetRunnr\ShopifyApp\Http\Controllers;

use Illuminate\Routing\Controller;
use FleetRunnr\ShopifyApp\Traits\AuthController as AuthControllerTrait;

/**
 * Responsible for authenticating the shop.
 */
class AuthController extends Controller
{
    use AuthControllerTrait;
}
