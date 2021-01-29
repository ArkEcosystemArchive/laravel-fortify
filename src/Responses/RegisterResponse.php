<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Responses;

use ARKEcosystem\Fortify\Models;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

final class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return new JsonResponse('', 201);
        }

        $invitationId = $request->get('invitation');
        if ($invitationId) {
            $invitation = Models::invitation()::findByUuid($invitationId);
            if ($invitation->user()->is($request->user())) {
                $urlGenerator = app(UrlGenerator::class);

                try {
                    $url = $urlGenerator->route('invitations.accept', $invitation);

                    return redirect()->to($url);
                } catch (RouteNotFoundException $e) {
                    // If the route is not defined it can continue to the default
                    // route
                }
            }
        }

        return redirect()->route('verification.notice');
    }
}
