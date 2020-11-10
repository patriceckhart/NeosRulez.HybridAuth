<?php
namespace NeosRulez\HybridAuth\Controller;

/*
 * This file is part of the NeosRulez.HybridAuth package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;


class AbstractProviderController extends ActionController {

    /**
     * @Flow\Inject
     * @var \Neos\Neos\Domain\Service\UserService
     */
    protected $userService;

    /**
     * @var \Neos\Flow\Security\AccountRepository
     * @Flow\Inject
     */
    protected $accountRepository;

    /**
     * @var \Neos\Flow\Security\Cryptography\HashService
     * @Flow\Inject
     */
    protected $hashService;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @param array $settings
     * @return void
     */
    public function injectSettings(array $settings) {
        $this->settings = $settings;
    }

    public function getProviderCredentials($provider) {
        $credentials = $this->settings['Provider'][$provider];
        return $credentials;
    }

    protected $authProvider = '';

    public function credentials() {
        return $this->getProviderCredentials($this->authProvider);
    }

    public function provider() {

    }

    public function loginAction() {
        $authUrl = $this->provider()->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $this->provider()->getState();
        $this->redirectToUri($authUrl);
    }

    public function authAction() {

        $args = $this->request->getArguments();

        if (array_key_exists('code', $args)) {

            $token = $this->provider()->getAccessToken('authorization_code', [
                'code' => $args['code']
            ]);

            try {
                $user = $this->provider()->getResourceOwner($token);
            } catch (Exception $e) {
                exit('Oh dear...');
            }

            $account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($user->getNickname(), 'Neos.Neos:Backend');

            if (!$account) {
                $defaultRole[] = $this->credentials()['defaultRole'];
                $this->userService->createUser($user->getNickname(), $token->getToken(), $user->getName(), '', $defaultRole, 'Neos.Neos:Backend');
                $this->persistenceManager->persistAll();
                $account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($user->getNickname(), 'Neos.Neos:Backend');
                $this->persistenceManager->whitelistObject($account);
            }

            $defaultRole[] = new \Neos\Flow\Security\Policy\Role($this->credentials()['defaultRole']);

            $account->setAccountIdentifier($user->getNickname());
            $account->setAuthenticationProviderName('Neos.Neos:Backend');
            $account->setRoles($defaultRole);
            $account->authenticationAttempted(\Neos\Flow\Security\Authentication\TokenInterface::AUTHENTICATION_SUCCESSFUL);

            $account->setCredentialsSource($this->hashService->hashPassword($token->getToken()));

            $this->persistenceManager->whitelistObject($account);
            $this->persistenceManager->update($account);

            $this->view->assign('username', $user->getNickname());
            $this->view->assign('token', $token->getToken());

        }

    }

}
