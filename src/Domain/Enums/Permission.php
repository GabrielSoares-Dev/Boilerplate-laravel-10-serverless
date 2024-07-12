<?php

namespace Src\Domain\Enums;

final class Permission
{
    const CREATE_PERMISSION = 'create_permission';

    const READ_ALL_PERMISSIONS = 'read_all_permissions';

    const DELETE_PERMISSION = 'delete_permission';

    const READ_PERMISSION = 'read_permission';

    const UPDATE_PERMISSION = 'update_permission';

    const CREATE_ROLE = 'create_role';

    const READ_ALL_ROLES = 'read_all_roles';

    const DELETE_ROLE = 'delete_role';

    const READ_ROLE = 'read_role';

    const UPDATE_ROLE = 'update_role';

    const SYNC_ROLE_WITH_PERMISSIONS = 'sync_role_with_permissions';

    const UNSYNC_ROLE_WITH_PERMISSIONS = 'unsync_role_with_permissions';
}
