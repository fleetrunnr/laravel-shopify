<?php

namespace FleetRunnr\ShopifyApp\Objects\Transfers;

use FleetRunnr\ShopifyApp\Objects\Values\ChargeReference;

/**
 * Reprecents details for a usage charge.
 */
final class UsageChargeDetails extends AbstractTransfer
{
    /**
     * The Shopify charge ID.
     *
     * @var ChargeReference
     */
    public $chargeReference;

    /**
     * Usage charge price.
     *
     * @var float
     */
    public $price;

    /**
     * Useage charge description.
     *
     * @var string
     */
    public $description;
}
