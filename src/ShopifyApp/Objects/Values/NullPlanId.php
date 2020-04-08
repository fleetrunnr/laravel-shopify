<?php

namespace FleetRunnr\ShopifyApp\Objects\Values;

use Funeralzone\ValueObjects\NullTrait;
use FleetRunnr\ShopifyApp\Contracts\Objects\Values\PlanId as PlanIdValue;

/**
 * Value object for plan's ID (null).
 */
final class NullPlanId implements PlanIdValue
{
    use NullTrait;
}
