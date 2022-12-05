<?php

namespace App\Traits\Requests;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait HasPicture
{
    /**
     * Minimum width
     *
     * @var integer
     */
    private $minWith = 100;

    /**
     * Maximum width
     *
     * @var integer
     */
    private $maxWith = 3840;

    /**
     * Minimum height
     *
     * @var integer
     */
    private $minHeight = 100;

    /**
     * Maximum height
     *
     * @var integer
     */
    private $maxHeight = 2160;

    /**
     * Image rules
     *
     * @param string       $name
     * @param integer|null $minWith
     * @param integer|null $minHeight
     * @param integer|null $maxWith
     * @param integer|null $maxHeight
     * @param boolean      $nullable
     * @return array
     */
    public function pictureRules(
        string $name = 'picture',
        ?int $minWith = null,
        ?int $minHeight = null,
        ?int $maxWith = null,
        ?int $maxHeight = null,
        bool $nullable = false
    ): array {
        $sizes = (object)[
            'minWith'   => $minWith ?? $this->minWith,
            'minHeight' => $minHeight ?? $this->minHeight,
            'maxWith'   => $maxWith ?? $this->maxWith,
            'maxHeight' => $maxHeight ?? $this->maxHeight
        ];
        return [
            $name => [
                !$nullable ? 'required' : 'nullable',
                function (string $attribute, $value, callable $fail) use ($sizes) {
                    return $this->validatePicture($attribute, $value, $fail, $sizes);
                }
            ]
        ];
    }

    /**
     * Images rules.
     *
     * @param string       $name
     * @param integer|null $minWith
     * @param integer|null $minHeight
     * @param integer|null $maxWith
     * @param integer|null $maxHeight
     * @return array
     */
    public function picturesRules(
        string $name = 'pictures',
        ?int $minWith = null,
        ?int $minHeight = null,
        ?int $maxWith = null,
        ?int $maxHeight = null
    ): array {
        $sizes = (object)[
            'minWith'   => $minWith ?? $this->minWith,
            'minHeight' => $minHeight ?? $this->minHeight,
            'maxWith'   => $maxWith ?? $this->maxWith,
            'maxHeight' => $maxHeight ?? $this->maxHeight
        ];
        return [
            $name => 'sometimes|array',
            "{$name}Validate" => "required_with:{$name}|array",
            "{$name}Validate.*" => [
                'required',
                function (string $attribute, $value, callable $fail) use ($sizes) {
                    return $this->validatePicture($attribute, $value, $fail, $sizes);
                }
            ]
        ];
    }

    /**
     * Validate picture.
     *
     * @param string   $attribute
     * @param mixed    $value
     * @param callback $fail
     * @param object   $sizes
     * @return void
     * @phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed
     */
    private function validatePicture(string $attribute, $value, callable $fail, object $sizes)
    {
        if (!($useStorage = Storage::exists($value)) and !File::exists($value)) {
            $fail(trans(":attribute n'existe pas dans le système de fichier"));
            return;
        }
        /** @var string */
        $fileFullPath = $this->getUploadedFileFullPath($value, $useStorage);
        if (
            !\in_array($this->getUploadedFileMimeType($value, $useStorage), [
                'image/jpeg', 'image/jpg', 'image/png', 'image/gif'
            ])
        ) {
            $fail(trans(":attribute doit être une image de type 'image/jpeg,image/jpg,image/png,image/gif'"));
        }
        if (!($dimensions = \getimagesize($fileFullPath)) or !isset($dimensions[0]) or !isset($dimensions[1])) {
            $fail(trans(":attribute impossible de valider les dimensions"));
        } else {
            $width  = intval($dimensions[0]);
            $height = intval($dimensions[1]);

            $xMessage = trans(
                ":attribute la largeur doit être comprise entre {$sizes->minWith}px et {$sizes->maxWith}px"
            );
            if ($sizes->minWith === $sizes->maxWith) {
                $xMessage = trans(":attribute la largeur doit être de {$sizes->minWith}px");
            }
            $yMessage = trans(
                ":attribute la hauteur doit être comprise entre {$sizes->minWith}px et {$sizes->maxWith}px"
            );
            if ($sizes->minHeight === $sizes->maxHeight) {
                $yMessage = trans(":attribute la hauteur doit être de {$sizes->minWith}px");
            }

            if (($width < $sizes->minWith) or ($width > $sizes->maxWith)) {
                $fail($xMessage);
            }
            if (($height < $sizes->minHeight) or ($height > $sizes->maxHeight)) {
                $fail($yMessage);
            }
        } //end if
    }

    /**
     * Merges picture field with request data.
     *
     * @param string $name
     * @return void
     */
    protected function mergePicture(string $name = 'picture'): void
    {
        $picturePath = $this->{$name};
        if (is_string($picturePath)) {
            $this->merge(["{$name}Validate" => []]);
            // ! Empty picture.
            if ($picturePath === 'false') {
                // * Empty picture and exit
                $this->merge([$name => []]);
                return;
            }
            $decodedPath = \urldecode($picturePath);
            $this->merge([
                "{$name}Validate" => array_merge(
                    $this->{"{$name}Validate"},
                    [\public_path(ltrim($decodedPath, '/'))]
                )
            ]);
            $changedPicture = ltrim($decodedPath, '/');
            $this->merge([
                $name => $changedPicture
            ]);
        } //end if
    }

    /**
     * Merges pictures fields with request data.
     *
     * @param string $name
     * @return void
     */
    protected function mergePictures(string $name = 'pictures'): void
    {
        $pictures = $this->{$name};
        if (is_array($pictures)) {
            $this->merge(["{$name}Validate" => []]);
            foreach ($pictures as $key => $picturePath) {
                // ! Empty picture.
                if ($picturePath === 'false') {
                    // * Empty picture and exit
                    $this->merge([$name => []]);
                    return;
                }
                $decodedPath = \urldecode($picturePath);
                $this->merge([
                    "{$name}Validate" => array_merge(
                        $this->{"{$name}Validate"},
                        [\public_path(ltrim($decodedPath, '/'))]
                    )
                ]);
                $changedPicture       = $this->{$name};
                $changedPicture[$key] = ltrim($decodedPath, '/');
                $this->merge([
                    $name => $changedPicture
                ]);
            }
        } //end if
    }

    /**
     * Get the file full path.
     *
     * @param string  $value
     * @param boolean $useStorage
     * @return string
     */
    private function getUploadedFileFullPath(string $value, bool $useStorage): string
    {
        return !$useStorage ? realpath($value) ?: $value : Storage::getAdapter()->applyPathPrefix($value);
    }

    /**
     * Get the file mimetype.
     *
     * @param string  $value
     * @param boolean $useStorage
     * @return string|false
     */
    private function getUploadedFileMimeType(string $value, bool $useStorage)
    {
        return !$useStorage ? File::mimeType($value) : Storage::mimeType($value);
    }
}
