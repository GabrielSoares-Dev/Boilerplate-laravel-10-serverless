<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\Permission;

class PermissionTest extends TestCase
{
    public function test_should_create_permission(): void
    {

        $permissionEntity = new Permission();
        $input = [
            'name' => 'create_permission',
            'guard_name' => 'api',
        ];

        $expectedOutput = [
            'name' => 'create_permission',
            'guard_name' => 'api',
        ];

        $output = $permissionEntity->create($input);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_create_permission_failure_when_name_is_invalid(): void
    {

        $permissionEntity = new Permission();
        $input = [
            'guard_name' => 'api',
        ];

        $this->expectExceptionMessage('Invalid name');

        $permissionEntity->create($input);
    }

    public function test_should_create_permission_failure_when_guard_name_is_invalid(): void
    {

        $permissionEntity = new Permission();
        $input = [
            'name' => 'create_permission',
        ];

        $this->expectExceptionMessage('Invalid guard name');

        $permissionEntity->create($input);
    }
}
