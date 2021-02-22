<?php

namespace Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUsersCreateRouteReturnsView()
    {
        $this->asUser()->get('users/create')->assertViewIs('users.create');
    }

    public function testUsersCrudRoutesRequiresAuthentication()
    {
        $this->get('users/create')->assertRedirect('login');
        $this->get('users/1')->assertRedirect('login');
        $this->get('users/1/edit')->assertRedirect('login');
        $this->post('users', [])->assertRedirect('login');
        $this->put('users/1', [])->assertRedirect('login');
        $this->delete('users/1', [])->assertRedirect('login');
    }

    public function testPostUsersStoreRouteInsertsUserOnDb()
    {
        $user = \App\Models\User::factory()->make([
            'name' => 'John Doe',
            'document' => '123.456.789-09',
        ]);

        $this->asUser()->post('users', $user->toArray())
            ->assertSessionHas(['status' => __("User created successfully.")]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'document' => '12345678909',
        ]);
    }

    public function testPostUsersStoreRouteValidation()
    {
        $this->asUser()->post('users', [])
            ->assertSessionHasErrors(['name', 'email', 'document']);
    }

    public function testGetUsersIndexRouteListUsers()
    {
        $users = \App\Models\User::factory()->times(20)->create();

        $this->asUser()->get('users')
            ->assertSee($users->get(0)->name)
            ->assertSee($users->get(1)->name)
            ->assertSee($users->get(2)->name)
            ->assertSee('?page=2');
    }

    public function testGetUsersShowRouteShowsAUser()
    {
        $user = \App\Models\User::factory()->create();

        $this->asUser()->get("users/{$user->id}")
            ->assertViewIs('users.show')
            ->assertViewHas(['user'])
            ->assertSee($user->name);
    }

    public function testGetUsersEditRouteReturnsView()
    {
        $user = \App\Models\User::factory()->create();

        $this->asUser()->get("users/{$user->id}/edit")
            ->assertViewIs('users.edit')
            ->assertViewHas(['user'])
            ->assertSee($user->name);
    }

    public function testPutUsersUpdateRouteUpdatesUserOnDb()
    {
        $user = \App\Models\User::factory()->create();

        $this->asUser()->put("users/{$user->id}", [
            'name' => 'Foo Car',
            'email' => $user->email,
            'document' => '12345678909'
        ])->assertRedirect(route('users.show', [$user]))
        ->assertSessionHas(['status' => __("User updated successfully.")]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Foo Car',
            'email' => $user->email,
            'document' => '12345678909'
        ]);
    }

    public function testPutUsersUpdateRouteValidation()
    {
        \App\Models\User::factory()->create(['document' => '12345678909']);

        $user = \App\Models\User::factory()->create(['document' => '11111111111']);

        $this->asUser()
            ->put("users/{$user->id}", [])
            ->assertSessionHasErrors(['name', 'email', 'document']);

        $data = \App\Models\User::factory()->make(['document' => '12345678909'])->toArray();

        $this->asUser()
            ->put("users/{$user->id}", $data)
            ->assertSessionHasErrors([
                'document' => "The document has already been taken."
            ]);
    }

    public function testDeleteUsersRouteRemovesUserFromDb()
    {
        $user = \App\Models\User::factory()->create();

        $this->asUser()->delete("users/{$user->id}", [])
            ->assertRedirect('users')
            ->assertSessionHas(['status' => __("User deleted successfully.")]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
