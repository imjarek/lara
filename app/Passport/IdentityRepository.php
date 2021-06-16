<?php

namespace App\Passport;

use OpenIDConnectServer\Repositories\IdentityProviderInterface;

class IdentityRepository implements IdentityProviderInterface
{
    /**
     * @param $identifier
     * @return User
     */
    public function getUserEntityByIdentifier($identifier)
    {
        return new \App\Passport\User($identifier);
    }
}
