<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $userData = [
            "name" => "Test User",
            "email" => "test@example.com",
            "password" => "password",
            "password_confirmation" => "password",
        ];

        $response = $this->postJson("/register", $userData);

        $response->assertNoContent();

        // Fetch the user that should have been created
        $user = User::where("email", $userData["email"])->first();

        $this->assertNotNull($user, "User was not created.");
        $this->assertAuthenticatedAs($user);
    }
}

