<?php

namespace App\Social;

use App\Social\Contracts\SocialProvider;
use Illuminate\Config\Repository as Config;

class SocialManager
{
    protected $config;

    protected $providers = [];

    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->loadProviders();
    }

    public function getActiveProviders()
    {
        return $this->getProviders()->filter(function ($provider) {
            return $provider->IsLoggedIn();
        });
    }

    public function getProvider($providerKey)
    {
        return $this->getProviders()->get($providerKey);
    }

    public function getProviders()
    {
        return collect($this->providers);
    }

    public function getProvidersSettings()
    {
        return $this->getProviders()->map(function ($provider) {
            return $provider->getRequiredSettings();
        });
    }

    protected function add(SocialProvider $provider)
    {
        $this->providers[strtolower($provider->getName())] = $provider;
    }

    protected function loadProviders()
    {
        $providers = $this->config->get('social.providers');

        foreach ($providers as $provider) {
            $this->add(app($provider));
        }
    }
}
