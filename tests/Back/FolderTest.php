<?php

namespace Tests\Back;

use App\Enums\Users\RoleEnum;
use App\Models\Folder;

use App\Models\User as AuthModel;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FolderTest extends TestCase
{
    /**
     * TESTS GUEST CANNOT ACCESS ROUTES
     */

    /** @return void */
    public function testGuestCannotAccessFoldersIndex(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'folders.' .
                config('unit-tests.view.resources-index')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessFoldersShow(): void
    {
        $model    = Folder::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'folders.' .
                config('unit-tests.view.resources-read'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessFoldersCreate(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'folders.' .
                config('unit-tests.view.resources-create')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccessFoldersEdit(): void
    {
        $model    = Folder::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                'folders.' .
                config('unit-tests.view.resources-update'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /**
     * TESTS GUEST CANNOT USE ROUTES.
     */

    /** @return void */
    public function testGuestCannotCreateFolder(): void
    {
        $model    = Folder::factory()->createOneQuietly();
        $response = $this->post(
            route(
                config('unit-tests.route.prefix') . 'folders.' . config('unit-tests.route.action-create'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotEditFolder(): void
    {
        $model    = Folder::factory()->createOneQuietly();
        $response = $this->patch(
            route(
                config('unit-tests.route.prefix') . 'folders.' . config('unit-tests.route.action-update'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotDestroyFolder(): void
    {
        $model    = Folder::factory()->createOneQuietly();
        $response = $this->delete(
            route(
                config('unit-tests.route.prefix') . 'folders.' . config('unit-tests.route.action-delete'),
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
    public function testUserConceptorCanAccessFoldersIndexView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'folders.' . config('unit-tests.view.resources-index'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.folders.' .
                config('unit-tests.view.resources-index')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessFoldersReadView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['role' => RoleEnum::conceptor]);
        $model    = Folder::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'folders.' . config('unit-tests.view.resources-read'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.folders.' .
                config('unit-tests.view.resources-read')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessFoldersCreateView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'folders.' . config('unit-tests.view.resources-create'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.folders.' .
                config('unit-tests.view.resources-create')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccessFoldersEditView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['role' => RoleEnum::conceptor]);
        $model    = Folder::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . 'folders.' . config('unit-tests.view.resources-update'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.folders.' .
                config('unit-tests.view.resources-update')
        );
    }

    /**
     * TESTS CAN FUNCTIONNALITIES.
     */

    /** @return void */
    public function testCanCreateFolder(): void
    {
        $folderCreated = Folder::factory()->createOneQuietly();
        $this->assertModelExists($folderCreated);
    }

    /** @return void */
    public function testCanUpdateFolder(): void
    {
        $folder = Folder::factory()->createOneQuietly();

        $fieldTest = "";
        foreach (config('unit-tests.list-fields') as $field) {
            if (Schema::hasColumn($folder->getTable(), $field)) {
                $folder->update([$field => "test"]);
                $fieldTest = $field;
                break;
            }
        }

        $this->assertTrue($folder->wasChanged());
        $this->assertTrue(array_key_exists($fieldTest, $folder->getChanges()));
        $this->assertModelExists($folder);
    }

    /** @return void */
    public function testCanDestroyFolder(): void
    {
        $folderDeleted = Folder::factory()->createOneQuietly();
        $folderDeleted->delete();
        $this->assertModelMissing($folderDeleted);
    }
}
