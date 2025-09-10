<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class TokenGuard implements Guard
{

    protected ?Authenticatable $user = null;

    public function __construct(
        protected UserProvider $provider,
        protected Request $request
    ) {}

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
        if ($this->user) {
            return $this->user;
        }

        $token = $this->request->header('X-Token');

        if ($token) {
            $this->user = $this->provider->retrieveByCredentials(['api_token' => $token]);
        }

        return $this->user;
    }

    public function id(): ?int
    {
        return $this->user()->getAuthIdentifier();
    }

    public function validate(array $credentials = [])
    {
        return !is_null($this->provider->retrieveByCredentials($credentials));
    }

    public function setUser(Authenticatable $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function hasUser(): bool
    {
        return !is_null($this->user);
    }
}
