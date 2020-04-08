<?php

namespace FleetRunnr\ShopifyApp\Storage\Queries;

use FleetRunnr\ShopifyApp\Objects\Values\ShopId;
use FleetRunnr\ShopifyApp\Objects\Values\ChargeId;
use FleetRunnr\ShopifyApp\Objects\Values\ChargeReference;
use FleetRunnr\ShopifyApp\Storage\Models\Charge as ChargeModel;
use FleetRunnr\ShopifyApp\Contracts\Queries\Charge as IChargeQuery;

/**
 * Reprecents a queries for charges.
 */
class Charge implements IChargeQuery
{
    /**
     * {@inheritdoc}
     */
    public function getById(ChargeId $chargeId, array $with = []): ?ChargeModel
    {
        return ChargeModel::with($with)
            ->where('id', $chargeId->toNative())
            ->get()
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getByReference(ChargeReference $chargeRef, array $with = []): ?ChargeModel
    {
        return ChargeModel::with($with)
            ->where('charge_id', $chargeRef->toNative())
            ->withTrashed()
            ->get()
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getByReferenceAndShopId(ChargeReference $chargeRef, ShopId $shopId): ?ChargeModel
    {
        return ChargeModel
            ::where('charge_id', $chargeRef->toNative())
            ->where('user_id', $shopId->toNative())
            ->get()
            ->first();
    }
}
