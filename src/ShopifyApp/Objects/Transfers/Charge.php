<?php

namespace FleetRunnr\ShopifyApp\Objects\Transfers;

use Illuminate\Support\Carbon;
use FleetRunnr\ShopifyApp\Contracts\Objects\Values\PlanId;
use FleetRunnr\ShopifyApp\Objects\Enums\ChargeStatus;
use FleetRunnr\ShopifyApp\Objects\Enums\ChargeType;
use FleetRunnr\ShopifyApp\Objects\Values\ChargeReference;
use FleetRunnr\ShopifyApp\Objects\Values\ShopId;

/**
 * Reprecents create charge.
 */
final class Charge extends AbstractTransfer
{
    /**
     * Shop ID.
     *
     * @var ShopId
     */
    public $shopId;

     /**
      * Plan ID.
      *
      * @var PlanId
      */
    public $planId;

    /**
     * Charge ID from Shopify.
     *
     * @var ChargeReference
     */
    public $chargeReference;

    /**
     * Charge type (recurring or single).
     *
     * @var ChargeType
     */
    public $chargeType;

    /**
     * Charge status.
     *
     * @var ChargeStatus $chargeStatus
     */
    public $chargeStatus;

    /**
     * When the charge was activated.
     *
     * @var Carbon
     */
    public $activatedOn;

    /**
     * When the charge will be billed on.
     *
     * @var Carbon|null
     */
    public $billingOn;

    /**
     * When the trial ends on.
     *
     * @var Carbon|null
     */
    public $trialEndsOn;

    /**
     * Plan details for reference.
     *
     * @var PlanDetails
     */
    public $planDetails;
}
