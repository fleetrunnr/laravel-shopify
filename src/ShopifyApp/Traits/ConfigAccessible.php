<?php

namespace FleetRunnr\ShopifyApp\Traits;

use Illuminate\Support\Facades\Config;

/**
 * Allows for getting of config data easily for the package.
 */
trait ConfigAccessible
{
    /**
     * Get the config value for a key.
     *
     * @param string $key The key to lookup.
     *
     * @return mixed
     */
    public function getConfig(string $key)
    {
        $this->config = array_merge(
            Config::get('shopify-app'),
            ['user_model' => Config::get('auth.providers.users.model')]
        );

        return $this->config[$key];
    }

    /**
     * Sets a config value for a key.
     *
     * @param string $key   The key to use.
     * @param mixed  $value The value to set.
     *
     * @return void
     */
    public function setConfig(string $key, $value): void
    {
        Config::set($key, $value);
    }

    /**
     * Set the config values for multiple keys.
     *
     * @param array $kvs.
     *
     * @return void
     */
    public function setConfigArray(array $kvs): void
    {
        foreach ($kvs as $key => $value) {
            Config::set($key, $value);
        }
    }

    /**
     * Helper function to get API key from shop (if custom mode) or from config
     * 
     * @param string $shop
     * 
     * @return string $api_key
     */
    public function getConfigApiKey(string $shop): string
    {
        if(!Config::get('shopify-app.custom_app_mode')) {
            return Config::get('shopify-app.api_key');
        }
        else {
            // Try to get value from shop
            $model = Config::get('auth.providers.users.model');
            $shopUser = $model::where('name', $shop)->first();
            return $shopUser ? $shopUser->shopify_api_key : '';
        }
    }

    /**
     * Helper function to get API secret from shop (if custom mode) or from config
     * 
     * @param string $shop
     * 
     * @return string $api_secret
     */
    public function getConfigApiSecret(string $shop): string
    {
        if(!Config::get('shopify-app.custom_app_mode')) {
            return Config::get('shopify-app.api_secret');
        }
        else {
            // Try to get value from shop
            $model = Config::get('auth.providers.users.model');
            $shopUser = $model::where('name', $shop)->first();
            return $shopUser ? $shopUser->shopify_api_secret : '';
        }
    }
}
