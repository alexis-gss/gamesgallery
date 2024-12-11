<?php

namespace Tests\Back\Models;

use App\Enums\Users\RoleEnum;
use App\Models\User;
use App\Models\User as AuthModel;
use Illuminate\Support\Facades\Schema;
use LaravelActivityLogs\Enums\ActivityLogsEventEnum;
use LaravelActivityLogs\Models\ActivityLog;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * TESTS GUEST CANNOT ACCESS ROUTES
     */

    /** @return void */
    public function testGuestCannotAccessUsersIndex(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'users.' .
                config('unit-tests.view.resources-index')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessUsersShow(): void
    {
        $model    = User::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'users.' .
                config('unit-tests.view.resources-read'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessUsersCreate(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'users.' .
                config('unit-tests.view.resources-create')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessUsersEdit(): void
    {
        $model    = User::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'users.' .
                config('unit-tests.view.resources-update'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /**
     * TESTS GUEST CANNOT USE ROUTES.
     */

    /** @return void */
    public function testGuestCannotCreateUser(): void
    {
        $model    = User::factory()->createOneQuietly();
        $response = $this->post(
            route(
                config('unit-tests.route.prefix') . 'users.' . config('unit-tests.route.action-create'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotEditUser(): void
    {
        $model    = User::factory()->createOneQuietly();
        $response = $this->patch(
            route(
                config('unit-tests.route.prefix') . 'users.' . config('unit-tests.route.action-update'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotDestroyUser(): void
    {
        $model    = User::factory()->createOneQuietly();
        $response = $this->delete(
            route(
                config('unit-tests.route.prefix') . 'users.' . config('unit-tests.route.action-delete'),
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
    public function testUserConceptorCanAccessUsersIndexView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'users.' . config('unit-tests.view.resources-index'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.users.' .
                config('unit-tests.view.resources-index')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessUsersReadView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $model    = User::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'users.' . config('unit-tests.view.resources-read'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.users.' .
                config('unit-tests.view.resources-read')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessUsersCreateView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'users.' . config('unit-tests.view.resources-create'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.users.' .
                config('unit-tests.view.resources-create')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessUsersEditView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $model    = User::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'users.' . config('unit-tests.view.resources-update'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.users.' .
                config('unit-tests.view.resources-update')
        );
    }

    /**
     * TESTS CAN FUNCTIONNALITIES.
     */

    /** @return void */
    public function testCanCreateUser(): void
    {
        $userCreated = User::factory()->createOneQuietly();
        $this->assertModelExists($userCreated);
    }

    /** @return void */
    public function testCanUpdateUser(): void
    {
        $user = User::factory()->createOneQuietly();

        $fieldTest = "";
        foreach (config('unit-tests.list-fields') as $field) {
            if (Schema::hasColumn($user->getTable(), $field)) {
                $user->update([$field => "test"]);
                $fieldTest = $field;
                break;
            }
        }

        $this->assertTrue($user->wasChanged());
        $this->assertTrue(array_key_exists($fieldTest, $user->getChanges()));
        $this->assertModelExists($user);
    }

    /** @return void */
    public function testCanDestroyUser(): void
    {
        $userDeleted = User::factory()->createOneQuietly();
        $userDeleted->delete();
        $this->assertModelMissing($userDeleted);
    }

    /**
     * TESTS RELATIONS
     */

    /** @return void */
    public function testRelationActivityLogs(): void
    {
        $user        = User::factory()->createOneQuietly();
        $activityLog = ActivityLog::factory()->createOneQuietly([
            'user_id'      => null,
            'is_anonymous' => true,
            'is_console'   => false,
            'model_class'  => sprintf("\%s", get_class($user)),
            'model_id'     => $user->getKey(),
            'event'        => ActivityLogsEventEnum::created->value(),
            'data'         => [],
            'created_at'   => now(),
        ]);
        $this->assertModelExists($user);
        $this->assertModelExists($activityLog);
        $this->assertIsObject($user->activityLogs);
        $this->assertCount(1, $user->activityLogs);
        $this->assertInstanceOf(ActivityLog::class, $user->activityLogs->first());
    }
}
