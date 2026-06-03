<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->post('/register', [
            'username' => 'Max Mustermann',
            'email' => 'max@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard'); // oder wohin dein Register leitet
        $this->assertDatabaseHas('users', ['email' => 'max@example.com']);
        $this->assertAuthenticated();
    }

    public function test_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'max@example.com',
            'password' => bcrypt('password123'), ]);

        $response = $this->post('/register', [
            'username' => 'Max Mustermann',
            'email' => 'max@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_registration_fails_if_passwords_dont_match(): void
    {
        $response = $this->post('/register', [
            'username' => 'Max Mustermann',
            'email' => 'max@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
