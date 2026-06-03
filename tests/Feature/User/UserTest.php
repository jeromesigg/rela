<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase; // DB wird vor jedem Test zurückgesetzt

    /**
     * A basic feature test example.
     */
    public function test_user_can_see_info_with_corrent_number(): void
    {
        $response = $this->post('/healthform', [
            'code' => '100001',
            'camp_code' => '1234',
        ]);

        $response->assertRedirect('/healthform'); // oder wohin dein Register leitet
    }
}
