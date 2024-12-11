<?php

namespace Tests\Back\Models;

use App\Enums\Users\RoleEnum;
use App\Models\Folder;
use App\Models\Game;
use App\Models\Picture;
use App\Models\Rank;
use App\Models\Tag;
use App\Models\User as AuthModel;
use App\Models\Visit;
use Illuminate\Support\Facades\Schema;
use LaravelActivityLogs\Enums\ActivityLogsEventEnum;
use LaravelActivityLogs\Models\ActivityLog;
use Tests\TestCase;

class GameTest extends TestCase
{
    /**
     * TESTS GUEST CANNOT ACCESS ROUTES
     */

    /** @return void */
    public function testGuestCannotAccessGamesIndex(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'games.' .
                config('unit-tests.view.resources-index')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessGamesShow(): void
    {
        $model    = Game::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'games.' .
                config('unit-tests.view.resources-read'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessGamesCreate(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'games.' .
                config('unit-tests.view.resources-create')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessGamesEdit(): void
    {
        $model    = Game::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'games.' .
                config('unit-tests.view.resources-update'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /**
     * TESTS GUEST CANNOT USE ROUTES.
     */

    /** @return void */
    public function testGuestCannotCreateGame(): void
    {
        $model    = Game::factory()->createOneQuietly();
        $response = $this->post(
            route(
                config('unit-tests.route.prefix') . 'games.' . config('unit-tests.route.action-create'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotEditGame(): void
    {
        $model    = Game::factory()->createOneQuietly();
        $response = $this->patch(
            route(
                config('unit-tests.route.prefix') . 'games.' . config('unit-tests.route.action-update'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotDestroyGame(): void
    {
        $model    = Game::factory()->createOneQuietly();
        $response = $this->delete(
            route(
                config('unit-tests.route.prefix') . 'games.' . config('unit-tests.route.action-delete'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /**
     * TESTS CONCEPTOR USER ACCESS ROUTES.
     */

    /** @return void */
    public function testUserConceptorCanAccessGamesIndexView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'games.' . config('unit-tests.view.resources-index'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.games.' .
                config('unit-tests.view.resources-index')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessGamesReadView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $model    = Game::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'games.' . config('unit-tests.view.resources-read'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.games.' .
                config('unit-tests.view.resources-read')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessGamesCreateView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'games.' . config('unit-tests.view.resources-create'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.games.' .
                config('unit-tests.view.resources-create')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessGamesEditView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $model    = Game::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'games.' . config('unit-tests.view.resources-update'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.games.' .
                config('unit-tests.view.resources-update')
        );
    }

    /**
     * TESTS CAN FUNCTIONNALITIES.
     */

    /** @return void */
    public function testCanCreateGame(): void
    {
        $gameCreated = Game::factory()->createOneQuietly();
        $this->assertModelExists($gameCreated);
    }

    /** @return void */
    public function testCanUpdateGame(): void
    {
        $game = Game::factory()->createOneQuietly();

        $fieldTest = "";
        foreach (config('unit-tests.list-fields') as $field) {
            if (Schema::hasColumn($game->getTable(), $field)) {
                $game->update([$field => "test"]);
                $fieldTest = $field;
                break;
            }
        }

        $this->assertTrue($game->wasChanged());
        $this->assertTrue(array_key_exists($fieldTest, $game->getChanges()));
        $this->assertModelExists($game);
    }

    /** @return void */
    public function testCanDestroyGame(): void
    {
        $gameDeleted = Game::factory()->createOneQuietly();
        $gameDeleted->delete();
        $this->assertModelMissing($gameDeleted);
    }

    /**
     * TESTS RELATIONS
     */

    /** @return void */
    public function testRelationFolder(): void
    {
        $folder = Folder::factory()->createOneQuietly();
        $game   = Game::factory()->createOneQuietly();
        $this->assertModelExists($folder);
        $this->assertModelExists($game);
        $this->assertInstanceOf(Folder::class, $game->folder);
    }

    /** @return void */
    public function testRelationTags(): void
    {
        $tag  = Tag::factory()->createOneQuietly();
        $game = Game::factory()->createOneQuietly();
        (new Tag())->setTags($game, collect([$tag->toArray()]));
        $this->assertModelExists($tag);
        $this->assertModelExists($game);
        $this->assertIsObject($game->tags);
        $this->assertCount(1, $game->tags);
        $this->assertInstanceOf(Tag::class, $game->tags->first());
        $this->assertDatabaseCount('taggables', 1);
    }

    /** @return void */
    public function testRelationPictures(): void
    {
        $game    = Game::factory()->createOneQuietly();
        $picture = Picture::factory()->createOneQuietly();
        $this->assertModelExists($game);
        $this->assertModelExists($picture);
        $this->assertIsObject($game->pictures);
        $this->assertCount(1, $game->pictures);
        $this->assertInstanceOf(Picture::class, $game->pictures->first());
    }

    /** @return void */
    public function testRelationRank(): void
    {
        $game = Game::factory()->createOneQuietly();
        $rank = Rank::factory()->createOneQuietly();
        $this->assertModelExists($game);
        $this->assertModelExists($rank);
        $this->assertInstanceOf(Rank::class, $game->rank);
    }

    /** @return void */
    public function testRelationVisits(): void
    {
        $game  = Game::factory()->createOneQuietly();
        $visit = Visit::factory()->createOneQuietly();
        $this->assertModelExists($game);
        $this->assertModelExists($visit);
        $this->assertIsObject($game->visits);
        $this->assertCount(1, $game->visits);
        $this->assertInstanceOf(Visit::class, $game->visits->first());
    }

    /** @return void */
    public function testRelationActivityLogs(): void
    {
        $game        = Game::factory()->createOneQuietly();
        $activityLog = ActivityLog::factory()->createOneQuietly([
            'user_id'      => null,
            'is_anonymous' => true,
            'is_console'   => false,
            'model_class'  => sprintf("\%s", get_class($game)),
            'model_id'     => $game->getKey(),
            'event'        => ActivityLogsEventEnum::created->value(),
            'data'         => [],
            'created_at'   => now(),
        ]);
        $this->assertModelExists($game);
        $this->assertModelExists($activityLog);
        $this->assertIsObject($game->activityLogs);
        $this->assertCount(1, $game->activityLogs);
        $this->assertInstanceOf(ActivityLog::class, $game->activityLogs->first());
    }
}
