<?php

namespace FleetRunnr\ShopifyApp\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use FleetRunnr\ShopifyApp\Actions\GetPlanUrl;
use FleetRunnr\ShopifyApp\Actions\ActivatePlan;
use FleetRunnr\ShopifyApp\Services\ShopSession;
use FleetRunnr\ShopifyApp\Objects\Values\PlanId;
use Illuminate\Contracts\View\View as ViewView;
use FleetRunnr\ShopifyApp\Actions\ActivateUsageCharge;
use FleetRunnr\ShopifyApp\Objects\Values\NullablePlanId;
use FleetRunnr\ShopifyApp\Http\Requests\StoreUsageCharge;
use FleetRunnr\ShopifyApp\Objects\Values\ChargeReference;
use FleetRunnr\ShopifyApp\Objects\Transfers\UsageChargeDetails as UsageChargeDetailsTransfer;

/**
 * Responsible for billing a shop for plans and usage charges.
 */
trait BillingController
{
    /**
     * Redirects to billing screen for Shopify.
     *
     * @param int|null    $plan        The plan's ID, if provided in route.
     * @param GetPlanUrl  $getPlanUrl  The action for getting the plan URL.
     * @param ShopSession $shopSession The shop session helper.
     *
     * @return ViewView
     */
    public function index(?int $plan = null, GetPlanUrl $getPlanUrl, ShopSession $shopSession): ViewView
    {
        // Get the plan URL for redirect
        $url = $getPlanUrl(
            $shopSession->getShop()->getId(),
            NullablePlanId::fromNative($plan)
        );

        // Do a fullpage redirect
        return View::make(
            'shopify-app::billing.fullpage_redirect',
            ['url' => $url]
        );
    }

    /**
     * Processes the response from the customer.
     *
     * @param int          $plan         The plan's ID.
     * @param Request      $request      The HTTP request object.
     * @param ActivatePlan $activatePlan The action for activating the plan for a shop.
     * @param ShopSession  $shopSession The shop session helper.
     *
     * @return RedirectResponse
     */
    public function process(
        int $plan,
        Request $request,
        ActivatePlan $activatePlan,
        ShopSession $shopSession
    ): RedirectResponse {
        // Activate the plan and save
        $result = $activatePlan(
            $shopSession->getShop()->getId(),
            new PlanId($plan),
            new ChargeReference($request->query('charge_id'))
        );

        // Go to homepage of app
        return Redirect::route('home')->with(
            $result ? 'success' : 'failure',
            'billing'
        );
    }

    /**
     * Allows for setting a usage charge.
     *
     * @param StoreUsageCharge    $request             The verified request.
     * @param ActivateUsageCharge $activateUsageCharge The action for activating a usage charge.
     * @param ShopSession         $shopSession         The shop session helper.
     *
     * @return RedirectResponse
     */
    public function usageCharge(
        StoreUsageCharge $request,
        ActivateUsageCharge $activateUsageCharge,
        ShopSession $shopSession
    ): RedirectResponse {
        $validated = $request->validated();

        // Create the transfer object
        $ucd = new UsageChargeDetailsTransfer();
        $ucd->price = $validated['price'];
        $ucd->description = $validated['description'];

        // Activate and save the usage charge
        $activateUsageCharge(
            $shopSession->getShop()->getId(),
            $ucd
        );

        // All done, return with success
        return isset($validated['redirect']) ?
            Redirect::to($validated['redirect'])->with('success', 'usage_charge') :
            Redirect::back()->with('success', 'usage_charge');
    }
}
