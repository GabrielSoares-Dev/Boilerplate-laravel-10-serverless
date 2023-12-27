<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\Role;

class RoleTest extends TestCase
{
    public function test_should_create(): void
    {

        $entity = new Role();
        $input = [
            'name' => 'admin',
            'guard_name' => 'api',
        ];

        $expectedOutput = [
            'name' => 'admin',
            'guard_name' => 'api',
        ];

        $output = $entity->create($input);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_create_failure_when_name_is_invalid(): void
    {

        $entity = new Role();
        $input = [
            'guard_name' => 'api',
        ];

        $this->expectExceptionMessage('Invalid name');

        $entity->create($input);
    }

    public function test_should_create_failure_when_guard_name_is_invalid(): void
    {

        $entity = new Role();
        $input = [
            'name' => 'admin',
            'guard_name' => 'test',
        ];

        $this->expectExceptionMessage('Invalid guard name');

        $entity->create($input);
    }

    public function test_should_update(): void
    {

        $entity = new Role();
        $input = [
            'name' => 'admin',
            'guard_name' => 'api',
        ];

        $output = $entity->update($input);

        $expectedOutput = [
            'name' => 'admin',
            'guard_name' => 'api',
        ];
        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_update_guard_name_invalid(): void
    {

        $entity = new Role();
        $input = [
            'name' => 'admin',
            'guard_name' => 'test',
        ];

        $this->expectExceptionMessage('Invalid guard name');

        $entity->update($input);

    }

    public function test_should_update_name_invalid(): void
    {

        $entity = new Role();
        $input = [
            'name' => '',
            'guard_name' => 'api',
        ];

        $this->expectExceptionMessage('Invalid name');

        $entity->update($input);

    }
}
