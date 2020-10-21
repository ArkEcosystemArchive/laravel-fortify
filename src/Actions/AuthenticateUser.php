<?php

namespace ARKEcosystem\Fortify\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use ARKEcosystem\Fortify\Models;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class AuthenticateUser
{
    protected Request $request;

    /**
     * @var \Illuminate\Http\Request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->username = Fortify::username();
        $this->altUsername = Config::get('fortify.alt_username');
    }

    public function handle()
    {
        $user = $this->fetchUser();

        if (! $user || ! Hash::check($this->request->password, $user->password)) {
            return;
        }

        $user->update(['last_login_at' => Carbon::now()]);

        return $user;
    }

    private function fetchUser()
    {
        $username = $this->getUsername();

        $query = Models::user()::query();

        $query->where(Fortify::username(), $username);

        if ($altUsername = Config::get('fortify.alt_username')) {
            $query->orWhere($altUsername, $username);
        }

        return $query->first();
    }

    private function getUsername()
    {
        return $this->request->get($this->username);
    }
}
