<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Application\Dtos\Entities\Permission\PermissionEntityDto;
use Src\Domain\Entities\Permission;

class PermissionTest extends TestCase
{
    public function test_should_create_permission(): void
    {
        $entity = new Permission(new PermissionEntityDto('create_permission'));

        $entity->create();

        $this->assertTrue(true);
    }

    public function test_should_create_permission_failure_when_name_is_invalid(): void
    {

        $entity = new Permission(new PermissionEntityDto(''));

        $this->expectExceptionMessage('Invalid name');

        $entity->create();
    }

    public function test_should_update(): void
    {

        $entity = new Permission(new PermissionEntityDto('create_permission'));

        $entity->update();

        $this->assertTrue(true);
    }

    public function test_should_update_name_invalid(): void
    {

        $entity = new Permission(new PermissionEntityDto(''));

        $this->expectExceptionMessage('Invalid name');

        $entity->update();
    }
}
