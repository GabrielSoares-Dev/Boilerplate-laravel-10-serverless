<?php

namespace Tests\Unit;

use App\Helpers\Cryptography;
use Tests\TestCase;

class CryptographyTest extends TestCase
{
    public function test_should_compare_hash_and_value(): void
    {
        $input = [
            'hash' => '$2y$12$KWSFtZMM.cvqAU5FTLZ0o./qPJWpMCs5Ad3diMqiZ9QWJeuvvf3Xi',
            'value' => 'Boilerplate@2023',
        ];

        $cryptography = new Cryptography();

        $output = $cryptography->compare($input['hash'], $input['value']);

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
    }
}
