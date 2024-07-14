<?php

namespace Tests\Helpers\Mocks;

use Illuminate\Support\Facades\Auth;

class AuthorizeMock
{
    public static function notHavePermissionMock()
    {
        Auth::shouldReceive('user')
            ->andReturnSelf();

        Auth::shouldReceive('getPermissionsViaRoles')
            ->andReturnSelf();

        Auth::shouldReceive('pluck')
            ->andReturnSelf();

        Auth::shouldReceive('toArray')
            ->andReturn([]);
    }
}
