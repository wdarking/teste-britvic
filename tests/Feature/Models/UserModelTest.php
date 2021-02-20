<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function testItHaveDocumentSetterMethodToSanitizeValue()
    {
        $user = \App\Models\User::factory()->make([
            'document' => '123.456.789-09',
        ]);

        $this->assertEquals(12345678909, $user->document);
    }
}
