<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        // seed users
        User::factory(10)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserIndex()
    {
        // seed some users
        $response = $this->json('get',route('api.users.index'));

        $response->assertStatus(200);

        $this->assertArrayHasKey('users', $response->json());
    }

    public function testStoreUser()
    {
        $data = [
            'name' => 'Example',
            'email' => 'email@example.com',
            'password' => 'secret1234',
        ];

        $response = $this->json('POST', route('api.users.store'), $data);

        $response->assertStatus(200);

        $this->assertArrayHasKey('user', $response->json());
    }

    public function testShowUser()
    {
        $id = 1;

        $response = $this->json('get', route('api.users.show', $id));

        $response->assertStatus(200);

        $this->assertArrayHasKey('user', $response->json());
    }

    public function testUpdateUser()
    {
        // define user id
        $id = 1;

        // define data to pass
        $data = [
            'name' => 'New user',
            'email' => 'mlab817@gmail.com',
        ];

        // make the response
        $response = $this->json('put', route('api.users.update', $id), $data);

        // check if status is 200
        $response->assertStatus(200);

        // get user
        $user = User::find($id);

        // check if the user value is now the same as data passed
        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
    }

    public function testDestroyUser()
    {
        $id = 1;

        $response = $this->json('delete', route('api.users.destroy', $id));

        $response->assertStatus(200);

        $this->assertArrayHasKey('message', $response->json());
    }
}
