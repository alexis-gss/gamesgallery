<?php

namespace Tests\Back;

use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /** @return void */
    public function testGuestCanViewLoginForm(): void
    {
        $response = $this->get(route(config('unit-tests.route.prefix') . 'login'));
        $response->assertSuccessful();
        $response->assertViewIs(config('unit-tests.view.prefix') . 'auth.login');
    }

    /** @return void */
    public function testGuestCannotAccessAdminDashboard(): void
    {
        $response = $this->get(route(config('unit-tests.route.prefix') . config('unit-tests.view.name-homepage')));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testUserCanAccessAdminDashboard(): void
    {
        $authModel    = User::factory()->createQuietly(['published' => true]);
        $response = $this->actingAs($authModel, 'backend')->get(route(config('unit-tests.route.prefix') . config('unit-tests.view.name-homepage')));
        $response->assertSuccessful();
        $response->assertViewIs(config('unit-tests.view.prefix') . 'pages.home');
    }

    /** @return void */
    public function testUserCannotViewLoginFormWhenAuthenticated(): void
    {
        $authModel    = User::factory()->createQuietly(['published' => true]);
        $response = $this->actingAs($authModel, 'backend')->get(route(config('unit-tests.route.prefix') . 'login'));
        $response->assertStatus(302);
    }
}
