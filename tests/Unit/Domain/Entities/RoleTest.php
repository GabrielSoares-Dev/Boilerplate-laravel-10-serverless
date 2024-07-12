<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\Role;
use Src\Application\Dtos\Entities\Role\RoleEntityDto;

class RoleTest extends TestCase
{
    public function test_should_create(): void
    {

        $entity = new Role(new RoleEntityDto('admin'));

        $entity->create();

        $this->assertTrue(true);
    }

    public function test_should_create_failure_when_name_is_invalid(): void
    {

        $entity = new Role(new RoleEntityDto(''));

        $this->expectExceptionMessage('Invalid name');

        $entity->create();
    }

    public function test_should_update(): void
    {

        $entity = new Role(new RoleEntityDto('admin'));

        $entity->update();

        $this->assertTrue(true);
    }

    public function test_should_update_name_invalid(): void
    {

        $entity = new Role(new RoleEntityDto(''));

        $this->expectExceptionMessage('Invalid name');

        $entity->update();
    }
}
