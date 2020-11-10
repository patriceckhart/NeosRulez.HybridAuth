<?php
namespace NeosRulez\HybridAuth\Controller;

/*
 * This file is part of the NeosRulez.HybridAuth package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;


class GithubController extends AbstractProviderController {

    protected $authProvider = 'github';

    public function provider() {
        $provider = new \League\OAuth2\Client\Provider\Github([
            'clientId'          => $this->credentials()['clientId'],
            'clientSecret'      => $this->credentials()['clientSecret'],
            'redirectUri'       => $this->credentials()['callBackUri']
        ]);
        return $provider;
    }

}
