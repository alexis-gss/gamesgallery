<?php

namespace Tests\Back\Models;

use App\Enums\Users\RoleEnum;
use App\Models\Game;
use App\Models\Tag;
use App\Models\User as AuthModel;
use Illuminate\Support\Facades\Schema;
use LaravelActivityLogs\Enums\ActivityLogsEventEnum;
use LaravelActivityLogs\Models\ActivityLog;
use Tests\TestCase;

class TagTest extends TestCase
{
    /**
     * TESTS GUEST CANNOT ACCESS ROUTES
     */

    /** @return void */
    public function testGuestCannotAccessTagsIndex(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'tags.' .
                config('unit-tests.view.resources-index')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessTagsShow(): void
    {
        $model    = Tag::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'tags.' .
                config('unit-tests.view.resources-read'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessTagsCreate(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'tags.' .
                config('unit-tests.view.resources-create')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessTagsEdit(): void
    {
        $model    = Tag::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'tags.' .
                config('unit-tests.view.resources-update'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /**
     * TESTS GUEST CANNOT USE ROUTES.
     */

    /** @return void */
    public function testGuestCannotCreateTag(): void
    {
        $model    = Tag::factory()->createOneQuietly();
        $response = $this->post(
            route(
                config('unit-tests.route.prefix') . 'tags.' . config('unit-tests.route.action-create'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotEditTag(): void
    {
        $model    = Tag::factory()->createOneQuietly();
        $response = $this->patch(
            route(
                config('unit-tests.route.prefix') . 'tags.' . config('unit-tests.route.action-update'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotDestroyTag(): void
    {
        $model    = Tag::factory()->createOneQuietly();
        $response = $this->delete(
            route(
                config('unit-tests.route.prefix') . 'tags.' . config('unit-tests.route.action-delete'),
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
    public function testUserConceptorCanAccessTagsIndexView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'tags.' . config('unit-tests.view.resources-index'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.tags.' .
                config('unit-tests.view.resources-index')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessTagsReadView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $model    = Tag::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'tags.' . config('unit-tests.view.resources-read'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.tags.' .
                config('unit-tests.view.resources-read')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessTagsCreateView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'tags.' . config('unit-tests.view.resources-create'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.tags.' .
                config('unit-tests.view.resources-create')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessTagsEditView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $model    = Tag::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'tags.' . config('unit-tests.view.resources-update'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.tags.' .
                config('unit-tests.view.resources-update')
        );
    }

    /**
     * TESTS CAN FUNCTIONNALITIES.
     */

    /** @return void */
    public function testCanCreateTag(): void
    {
        $tagCreated = Tag::factory()->createOneQuietly();
        $this->assertModelExists($tagCreated);
    }

    /** @return void */
    public function testCanUpdateTag(): void
    {
        $tag = Tag::factory()->createOneQuietly();

        $fieldTest = "";
        foreach (config('unit-tests.list-fields') as $field) {
            if (Schema::hasColumn($tag->getTable(), $field)) {
                $tag->update([$field => "test"]);
                $fieldTest = $field;
                break;
            }
        }

        $this->assertTrue($tag->wasChanged());
        $this->assertTrue(array_key_exists($fieldTest, $tag->getChanges()));
        $this->assertModelExists($tag);
    }

    /** @return void */
    public function testCanDestroyTag(): void
    {
        $tagDeleted = Tag::factory()->createOneQuietly();
        $tagDeleted->delete();
        $this->assertModelMissing($tagDeleted);
    }

    /**
     * TESTS RELATIONS
     */

    /** @return void */
    public function testRelationGames(): void
    {
        $tag  = Tag::factory()->createOneQuietly();
        $game = Game::factory()->createOneQuietly();
        (new Tag())->setTags($game, collect([$tag->toArray()]));
        $this->assertModelExists($tag);
        $this->assertModelExists($game);
        $this->assertIsObject($tag->games);
        $this->assertCount(1, $tag->games);
        $this->assertInstanceOf(Game::class, $tag->games->first());
        $this->assertDatabaseCount('taggables', 1);
    }

    /** @return void */
    public function testRelationActivityLogs(): void
    {
        $tag         = Tag::factory()->createOneQuietly();
        $activityLog = ActivityLog::factory()->createOneQuietly([
            'user_id'      => null,
            'is_anonymous' => true,
            'is_console'   => false,
            'model_class'  => sprintf("\%s", get_class($tag)),
            'model_id'     => $tag->getKey(),
            'event'        => ActivityLogsEventEnum::created->value(),
            'data'         => [],
            'created_at'   => now(),
        ]);
        $this->assertModelExists($tag);
        $this->assertModelExists($activityLog);
        $this->assertIsObject($tag->activityLogs);
        $this->assertCount(1, $tag->activityLogs);
        $this->assertInstanceOf(ActivityLog::class, $tag->activityLogs->first());
    }
}
