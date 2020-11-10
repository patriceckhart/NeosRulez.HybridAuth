<?php
namespace NeosRulez\HybridAuth\Controller;

/*
 * This file is part of the NeosRulez.HybridAuth package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;


class FacebookController extends AbstractProviderController {

    protected $authProvider = 'facebook';

    public function provider() {
        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId'          => $this->credentials()['facebookAppId'],
            'clientSecret'      => $this->credentials()['facebookAppSecret'],
            'redirectUri'       => $this->credentials()['redirectUri'],
            'graphApiVersion'   => 'v2.10'
        ]);
        return $provider;
    }

}
