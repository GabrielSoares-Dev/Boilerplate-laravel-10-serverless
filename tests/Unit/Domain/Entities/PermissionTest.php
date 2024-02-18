<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\Permission;

class PermissionTest extends TestCase
{
    public function test_should_create_permission(): void
    {
        $entity = new Permission();

        $entity->create('create_permission', 'api');

        $this->assertTrue(true);
    }

    public function test_should_create_permission_failure_when_name_is_invalid(): void
    {

        $entity = new Permission();

        $this->expectExceptionMessage('Invalid name');

        $entity->create('', 'api');
    }

    public function test_should_create_permission_failure_when_guard_name_is_invalid(): void
    {

        $entity = new Permission();

        $this->expectExceptionMessage('Invalid guard name');

        $entity->create('create_permission', 'test');
    }

    public function test_should_update(): void
    {

        $entity = new Permission();
        $input = [
            'name' => 'create_permission',
            'guard_name' => 'api',
        ];

        $entity->update($input);

        $this->assertTrue(true);
    }

    public function test_should_update_guard_name_invalid(): void
    {

        $entity = new Permission();
        $input = [
            'name' => 'create_permission',
            'guard_name' => 'test',
        ];

        $this->expectExceptionMessage('Invalid guard name');

        $entity->update($input);
    }

    public function test_should_update_name_invalid(): void
    {

        $entity = new Permission();
        $input = [
            'name' => '',
            'guard_name' => 'api',
        ];

        $this->expectExceptionMessage('Invalid name');

        $entity->update($input);
    }
}
