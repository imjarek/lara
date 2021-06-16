<?php

namespace App\Providers;

use League\OAuth2\Server\AuthorizationServer;
use OpenIDConnectServer\IdTokenResponse;
use App\Passport\IdentityRepository;
use OpenIDConnectServer\ClaimExtractor;

class PassportServiceProvider extends \Laravel\Passport\PassportServiceProvider
{
    /**
     * Make the authorization service instance.
     *
     * @return \League\OAuth2\Server\AuthorizationServer
     */
    public function makeAuthorizationServer()
    {
        $responseType = new IdTokenResponse(new IdentityRepository(), new ClaimExtractor());

        return new AuthorizationServer(
            $this->app->make(\Laravel\Passport\Bridge\ClientRepository::class),
            $this->app->make(\Laravel\Passport\Bridge\AccessTokenRepository::class),
            $this->app->make(\Laravel\Passport\Bridge\ScopeRepository::class),
            $this->makeCryptKey('private'),
            app('encrypter')->getKey(),
            $responseType
        );
    }
}
