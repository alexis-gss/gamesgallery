<?php

namespace Tests\Back\Models;

use App\Enums\Users\RoleEnum;
use App\Models\Game;
use App\Models\Rank;
use App\Models\User as AuthModel;
use Tests\TestCase;

class RankTest extends TestCase
{
    /**
     * TESTS GUEST CANNOT ACCESS VIEWS.
     */

    /** @return void */
    public function testGuestCannotAccessRanksIndexView(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'ranks.' .
                config('unit-tests.view.resources-index')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /**
     * TESTS USER CONCEPTOR ACCESS VIEWS.
     */

    /** @return void */
    public function testUserConceptorCanAccessRanksIndexView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'ranks.' . config('unit-tests.view.resources-index'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.ranks.' .
                config('unit-tests.view.resources-index')
        );
    }

    /**
     * TESTS RELATIONS
     */

    /** @return void */
    public function testRelationGame(): void
    {
        $game = Game::factory()->createOneQuietly();
        $rank = Rank::factory()->createOneQuietly();
        $this->assertModelExists($rank);
        $this->assertModelExists($game);
        $this->assertInstanceOf(Game::class, $rank->game);
    }
}
