<?php

namespace FleetRunnr\ShopifyApp\Storage\Queries;

use Illuminate\Support\Collection;
use FleetRunnr\ShopifyApp\Contracts\ShopModel;
use FleetRunnr\ShopifyApp\Objects\Values\ShopId;
use FleetRunnr\ShopifyApp\Traits\ConfigAccessible;
use FleetRunnr\ShopifyApp\Contracts\Objects\Values\ShopDomain as ShopDomainValue;
use FleetRunnr\ShopifyApp\Contracts\Queries\Shop as IShopQuery;

/**
 * Reprecents shop queries.
 */
class Shop implements IShopQuery
{
    use ConfigAccessible;

    /**
     * The shop model (configurable).
     *
     * @var ShopModel
     */
    protected $model;

    /**
     * Setup.
     *
     * @return self
     */
    public function __construct()
    {
        $this->model = $this->getConfig('user_model');
    }

    /**
     * {@inheritdoc}
     */
    public function getByID(ShopId $shopId, array $with = [], bool $withTrashed = false): ?ShopModel
    {
        $result = $this->model::with($with);
        if ($withTrashed) {
            $result = $result->withTrashed();
        }

        return $result
            ->get()
            ->where('id', $shopId->toNative())
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getByDomain(ShopDomainValue $domain, array $with = [], bool $withTrashed = false): ?ShopModel
    {
        $result = $this->model::with($with);
        if ($withTrashed) {
            $result = $result->withTrashed();
        }

        return $result
            ->get()
            ->where('name', $domain->toNative())
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(array $with = []): Collection
    {
        return $this->model::with($with)
            ->get();
    }
}
