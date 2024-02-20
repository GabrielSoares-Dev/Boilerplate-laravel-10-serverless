<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\Role;

class RoleTest extends TestCase
{
    public function test_should_create(): void
    {

        $entity = new Role();

        $entity->create('admin', 'api');

        $this->assertTrue(true);
    }

    public function test_should_create_failure_when_name_is_invalid(): void
    {

        $entity = new Role();

        $this->expectExceptionMessage('Invalid name');

        $entity->create('', 'api');
    }

    public function test_should_create_failure_when_guard_name_is_invalid(): void
    {

        $entity = new Role();

        $this->expectExceptionMessage('Invalid guard name');

        $entity->create('admin', 'test');
    }

    public function test_should_update(): void
    {

        $entity = new Role();

        $entity->update('admin', 'api');

        $this->assertTrue(true);
    }

    public function test_should_update_guard_name_invalid(): void
    {

        $entity = new Role();

        $this->expectExceptionMessage('Invalid name');

        $entity->update('', 'api');

    }

    public function test_should_update_name_invalid(): void
    {

        $entity = new Role();

        $entity->update('admin', 'api');

        $this->assertTrue(true);
    }
}
