<?php

namespace FleetRunnr\ShopifyApp\Contracts\Commands;

use Illuminate\Support\Carbon as Carbon;
use FleetRunnr\ShopifyApp\Objects\Values\ShopId;
use FleetRunnr\ShopifyApp\Objects\Values\ChargeId;
use FleetRunnr\ShopifyApp\Objects\Values\ChargeReference;
use FleetRunnr\ShopifyApp\Objects\Transfers\Charge as ChargeTransfer;
use FleetRunnr\ShopifyApp\Objects\Transfers\UsageCharge as UsageChargeTransfer;

/**
 * Reprecents commands for charges.
 */
interface Charge
{
    /**
     * Create a charge entry.
     *
     * @param ChargeTransfer $chargeObj The charge object.
     *
     * @return ChargeId
     */
    public function make(ChargeTransfer $chargeObj): ChargeId;

    /**
     * Deletes a charge for a shop.
     *
     * @param ChargeReference $chargeRef The charge ID from Shopify.
     * @param ShopId          $shopId   The shop's ID.
     */
    public function delete(ChargeReference $chargeRef, ShopId $shopId): bool;

    /**
     * Create a usage charge.
     *
     * @param UsageChargeTransfer $chargeObj The usage charge object.
     *
     * @return ChargeId
     */
    public function makeUsage(UsageChargeTransfer $chargeObj): ChargeId;

    /**
     * Cancels a charge for a shop.
     *
     * @param ChargeReference $chargeRef   The charge ID from Shopify.
     * @param Carbon          $expiresOn   Date of expiration.
     * @param Carbon          $trialEndsOn Date of when trial ends on based on remaining.
     *
     * @return bool
     */
    public function cancel(
        ChargeReference $chargeRef,
        ?Carbon $expiresOn = null,
        ?Carbon $trialEndsOn = null
    ): bool;
}
