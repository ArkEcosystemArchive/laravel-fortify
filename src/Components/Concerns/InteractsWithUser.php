<?php

namespace ARKEcosystem\Fortify\Components\Concerns;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

trait InteractsWithUser
{
    public function getUserProperty(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }
}
