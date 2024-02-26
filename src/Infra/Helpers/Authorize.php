<?php

namespace Src\Infra\Helpers;

use Illuminate\Support\Facades\Auth;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Exceptions\HttpException;

/**
 * @codeCoverageIgnore
 */
class Authorize
{
    public static function hasPermission(string $permission): void
    {
        $permissions = Auth::user()->getPermissionsViaRoles()->pluck('name')->toArray();

        $notHavePermission = !in_array($permission, $permissions);

        if ($notHavePermission) throw new HttpException('Access to this resource was denied', HttpCode::FORBIDDEN);
    }
}
