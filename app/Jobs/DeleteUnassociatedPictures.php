<?php

namespace App\Jobs;

use App\Models\Game;
use App\Models\Picture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteUnassociatedPictures implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * All directories of pictures from storage.
     *
     * @var array<string>
     */
    private $storageDirectories = [];

    /**
     * All pictures saved from storage.
     *
     * @var array<string>
     */
    private $storagePictures = [];

    /**
     * All games slug saved from database.
     *
     * @var array<string>
     */
    private $gamesSlug = [];

    /**
     * All pictures saved from database.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $pictures = [];

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->storageDirectories = Storage::disk("public")->allDirectories("pictures");
        $this->storagePictures    = Storage::disk("public")->allFiles("pictures");
        $this->gamesSlug          = Game::query()->get()->pluck("slug")->toArray();
        $this->pictures           = Picture::query()->get();
        $this->handle();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->deleteChunks();
        $this->deleteUnassociatedDirectories();
        $this->deleteUnassociatedPictures();
    }

    /**
     * Delete all failed/uncompleted chunks.
     *
     * @return void
     */
    public function deleteChunks(): void
    {
        Storage::deleteDirectory("chunks");
    }

    /**
     * Delete all directories which have not equivalent to a game slug in the database.
     *
     * @return void
     */
    public function deleteUnassociatedDirectories(): void
    {
        foreach ($this->storageDirectories as $directory) {
            $directoryExplode = explode("/", $directory);
            if (!in_array($directoryExplode[count($directoryExplode) - 1], $this->gamesSlug)) {
                Storage::disk("public")->deleteDirectory($directory);
            }
        }
    }

    /**
     * Delete all pictures which have not equivalent to a picture uuid in the database.
     *
     * @return void
     */
    public function deleteUnassociatedPictures(): void
    {
        foreach ($this->storagePictures as $picture) {
            $result = $this->pictures->where("uuid", explode(".", explode("/", $picture)[2])[0]);
            if (!count($result)) {
                Storage::disk("public")->delete($picture);
            }
        }
    }
}
