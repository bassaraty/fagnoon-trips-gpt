<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Tests\TestCase;
use Illuminate\Support\Facades\Password;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_can_be_requested(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        Notification::fake();
        $user = User::factory()->create();
        $this->postJson("/forgot-password", ["email" => $user->email]);
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        Notification::fake();
        $user = User::factory()->create();
        $token = Password::broker()->createToken($user);
        $response = $this->postJson("/reset-password", [
            "token" => $token,
            "email" => $user->email,
            "password" => "password",
            "password_confirmation" => "password",
        ]);
        $response->assertStatus(200);
        $this->assertTrue(password_verify("password", $user->fresh()->password));
    }
}

