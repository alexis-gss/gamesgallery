<?php

namespace Tests\Back\Models;

use App\Enums\Users\RoleEnum;
use App\Models\User as AuthModel;
use LaravelActivityLogs\Models\ActivityLog;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    /**
     * TESTS GUEST CANNOT ACCESS VIEWS.
     */

    /** @return void */
    public function testGuestCannotAccessActivityLogsIndexView(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'activity_logs.' .
                config('unit-tests.view.resources-index')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessActivityLogsReadView(): void
    {
        $model    = ActivityLog::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'activity_logs.' .
                config('unit-tests.view.resources-read'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /**
     * TESTS USER CONCEPTOR ACCESS VIEWS.
     */

    /** @return void */
    public function testUserConceptorCanAccessActivityLogsIndexView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'activity_logs.' . config('unit-tests.view.resources-index'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.activity_logs.' .
                config('unit-tests.view.resources-index')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessActivityLogsReadView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['published' => true, 'role' => RoleEnum::conceptor]);
        $model    = ActivityLog::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'activity_logs.' . config('unit-tests.view.resources-read'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.activity_logs.' .
                config('unit-tests.view.resources-read')
        );
    }
}
