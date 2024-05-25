<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class PictureController extends Controller
{
    /**
     * Upload multiple chunks of the image.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException Bla.
     */
    public function upload(Request $request)
    {
        // Create the file receiver.
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        // Check if the upload is success, throw exception or return response you need.
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // Receive the file.
        $save = $receiver->receive();
        // Check if the upload has finished (in chunk mode it will send smaller files).
        if ($save->isFinished()) {
            // Save the file and return any response you need, current example uses `move` function.
            // If you are not using move, you need to manually delete the file: unlink($save->getFile()->getPathname()).
            return $this->store(
                $save->getFile(),
                (isset($request->uuid)) ? $request->uuid : false,
                (isset($request->gameSlug)) ? $request->gameSlug : false
            );
        }
        // We are in chunk mode, lets send the current progress.
        /** @var \Pion\Laravel\ChunkUpload\Handler\AbstractHandler $handler */
        $handler = $save->handler();
        return response()->json([
            "done"   => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Store the uploaded image on .webp format in storage.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param mixed                         $uuid
     * @param string                        $gameSlug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException Bla.
     */
    protected function store(UploadedFile $file, mixed $uuid, string $gameSlug)
    {
        if ($uuid === false) {
            $uuid = Str::uuid();
        }

        /** @var string $currentImageName Current name of the uploaded image */
        $currentImageName = $uuid . "." . $file->getClientOriginalExtension();

        /** @var string $finalImageName Finale name of the uploaded image */
        $finalImageName = $uuid . ".webp";

        /** @var string $finalPath Image storage folder path */
        $finalPath = Storage::disk("public")->path(sprintf("pictures/%s/", $gameSlug));

        // Save image on default format.
        $file->move($finalPath, $currentImageName);

        // Change the image format at webp.
        /** @var resource|\GdImage|false $image */
        $image = false;
        switch ($file->getClientOriginalExtension()) {
            case 'jpg':
                $image = imagecreatefromjpeg($finalPath . $currentImageName);
                break;
            case 'jpeg':
                $image = imagecreatefromjpeg($finalPath . $currentImageName);
                break;
            case 'png':
                $image = imagecreatefrompng($finalPath . $currentImageName);
                break;
        }
        imagewebp($image, $finalPath . $finalImageName);

        // Delete uploaded image with old extension.
        unlink($finalPath . $currentImageName);

        return response()->json([
            'uid' => $uuid,
        ]);
    }
}
