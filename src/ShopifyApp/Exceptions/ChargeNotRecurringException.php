<?php

namespace FleetRunnr\ShopifyApp\Exceptions;

/**
 * Exception for when a charge is not recurring but a recurring action is attempted.
 */
class ChargeNotRecurringException extends BaseException
{
}
