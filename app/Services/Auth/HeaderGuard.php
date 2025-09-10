<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;

class HeaderGuard implements Guard
{

    protected ?Authenticatable $user = null;

    public function __construct(protected Request $request) {}
    public function check(): bool
    {
        return !is_null($this->user());
    }

    public function guest(): bool
    {
        return !$this->check();
    }

    public function user(): ?Authenticatable
    {

        if (!$this->user && $this->request->header('X-Access') === 'secret') {
            $this->user = new class implements Authenticatable {
                public function getAuthIdentifierName()
                {
                    return 'id';
                }

                public function getAuthIdentifier()
                {
                    return 1;
                }

                public function getAuthPassword()
                {
                    return null;
                }

                public function getRememberToken()
                {
                    return null;
                }

                public function setRememberToken($value) {}

                public function getRememberTokenName()
                {
                    return null;
                }

                public function getAuthPasswordName()
                {
                    return null;
                }
            };
        }

        return $this->user;
    }

    public function id(): ?int
    {
        return $this->user()?->getAuthIdentifier();
    }

    public function validate(array $credentials = []): bool
    {
        return $credentials['key'] == 'secret';
    }

    public function setUser(Authenticatable $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function  hasUser()
    {
        return !is_null($this->user);
    }

    //Test
    //curl -H "X-Access: secret" http://localhost:9000/test-custom-auth-header
}
