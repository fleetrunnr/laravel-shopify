<?php

namespace FleetRunnr\ShopifyApp\Http\Controllers;

use Illuminate\Routing\Controller;
use FleetRunnr\ShopifyApp\Traits\HomeController as HomeControllerTrait;

/**
 * Responsible for showing the main homescreen for the app.
 */
class HomeController extends Controller
{
    use HomeControllerTrait;
}
