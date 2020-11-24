<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Actions;

class DeleteUser
{
    /**
     * Delete the given user.
     *
     * @param mixed $user
     *
     * @return void
     */
    public function delete($user)
    {
        $user->delete();
    }
}
