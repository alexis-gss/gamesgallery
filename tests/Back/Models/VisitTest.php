<?php

namespace Tests\Back\Models;

use App\Models\Visit;
use Tests\TestCase;

class VisitTest extends TestCase
{
    /**
     * TESTS CAN ACTIONS ON MODEL.
     */

    /** @return void */
    public function testCanCreateVisit(): void
    {
        $model = Visit::factory()->createOneQuietly();
        $this->assertModelExists($model);
    }

    /** @return void */
    public function testCanDeleteVisit(): void
    {
        $model = Visit::factory()->createOneQuietly();
        $model->delete();
        $this->assertModelMissing($model);
    }
}
