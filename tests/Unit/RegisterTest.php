<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;


class RegisterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRequiredFieldsForRegistration()
    {
//        $userData = [
//            "name" => "John Doe",
//            "email" => "doe@example.com",
//            "desc" => "demo12345",
//            "api_token" => "demo12345",
//            "password"=>"asdasd"
//        ];
        $userData = User::factory()->create();
//        $this->json('POST', 'api/user/signup',$userData, ['Accept' => 'application/json'])
//            ->assertStatus(200);
        $this->actingAs($userData)->json('POST', 'api/user/signup', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
