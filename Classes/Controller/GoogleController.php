<?php
namespace NeosRulez\HybridAuth\Controller;

/*
 * This file is part of the NeosRulez.HybridAuth package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;


class GoogleController extends AbstractProviderController {

    protected $authProvider = 'google';

    public function provider() {
        $provider = new \League\OAuth2\Client\Provider\Google([
            'clientId'          => $this->credentials()['googleClientId'],
            'clientSecret'      => $this->credentials()['googleClientSecret'],
            'redirectUri'       => $this->credentials()['callBackUri']
        ]);
        return $provider;
    }


}
