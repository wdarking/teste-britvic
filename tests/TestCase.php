<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Helper function to authenticate as user.
     *
     * @param User $user
     * @param string $driver
     * @return $this
     */
    public function asUser(User $user = null, $driver = 'web')
    {
        if (!$user) {
            $user = \App\Models\User::factory()->create();
        }

        return $this->actingAs($user, $driver);
    }
}
