<?php

namespace FleetRunnr\ShopifyApp\Http\Controllers;

use Illuminate\Routing\Controller;
use FleetRunnr\ShopifyApp\Traits\WebhookController as WebhookControllerTrait;

/**
 * Responsible for handling incoming webhook requests.
 */
class WebhookController extends Controller
{
    use WebhookControllerTrait;
}
