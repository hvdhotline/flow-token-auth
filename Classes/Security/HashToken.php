<?php
namespace Flownative\TokenAuthentication\Security;

use Neos\Flow\Mvc\ActionRequest;
use Neos\Flow\Security\Authentication\Token\AbstractToken;

/**
 * A Flow security token that authenticates based on a hash delivered via GET request.
 */
class HashToken extends AbstractToken
{
    /**
     * @var array
     */
    protected $credentials;

    /**
     * @param ActionRequest $actionRequest
     * @return bool|void
     * @throws \Neos\Flow\Security\Exception\InvalidAuthenticationStatusException
     */
    public function updateCredentials(ActionRequest $actionRequest)
    {
        if ($actionRequest->getHttpRequest()->getMethod() !== 'GET') {
            return;
        }

        $authenticationHashToken = $actionRequest->getHttpRequest()->getAttribute('_authenticationHashToken');

        if (!$authenticationHashToken) {
            return;
        }

        $this->credentials['password'] = $authenticationHashToken;
        $this->setAuthenticationStatus(self::AUTHENTICATION_NEEDED);
    }
}
