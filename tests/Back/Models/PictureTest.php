<?php

namespace Tests\Back\Models;

use App\Models\Game;
use App\Models\Picture;
use App\Models\Rating;
use Tests\TestCase;

class PictureTest extends TestCase
{
    /**
     * TESTS CAN ACTIONS ON MODEL.
     */

    /** @return void */
    public function testCanCreatePicture(): void
    {
        $model = Picture::factory()->createOneQuietly();
        $this->assertModelExists($model);
    }

    /** @return void */
    public function testCanDeletePicture(): void
    {
        $model = Picture::factory()->createOneQuietly();
        $model->delete();
        $this->assertModelMissing($model);
    }

    /**
     * TESTS RELATIONS
     */

    /** @return void */
    public function testRelationGame(): void
    {
        $game    = Game::factory()->createOneQuietly();
        $picture = Picture::factory()->createOneQuietly();
        $this->assertModelExists($game);
        $this->assertModelExists($picture);
        $this->assertInstanceOf(Game::class, $picture->game);
    }

    /** @return void */
    public function testRelationRatings(): void
    {
        $picture = Picture::factory()->createOneQuietly();
        $rating  = Rating::factory()->createOneQuietly();
        $this->assertModelExists($picture);
        $this->assertModelExists($rating);
        $this->assertIsObject($picture->ratings);
        $this->assertCount(1, $picture->ratings);
        $this->assertInstanceOf(Rating::class, $picture->ratings->first());
    }
}
