<?php

namespace App\Lib;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Some utilities methods
 */
class Utils
{
    /**
     * Destroy folder.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public static function destroyFolder(Model $model): void
    {
        $pathFolder = \storage_path(sprintf('app/public/images/%s', $model->slug));
        if (File::exists($pathFolder)) {
            File::deleteDirectory($pathFolder);
        }
    }
    /**
     * Store an image of different types
     *
     * @param \Illuminate\Database\Eloquent\Model               $model
     * @param \Illuminate\Http\UploadedFile|\SplFileInfo|string $image
     * @return string
     * @throws \ErrorException If file copy fails.
     */
    public static function storeImage(Model $model, $image): string
    {
        if (\is_object($image) and $image instanceof \Illuminate\Http\UploadedFile) {
            /** @var \Illuminate\Http\UploadedFile $image */
            $newPath = self::prepareMoveFile($image->getClientOriginalName(), $model->slug);
            $newPath = str_replace(storage_path('app'), '', $newPath);
            $image->storePubliclyAs(
                pathinfo($newPath, \PATHINFO_DIRNAME),
                pathinfo($newPath, \PATHINFO_BASENAME)
            );
            return 'storage' . str_replace('/public', '', $newPath);
        }
        if (\is_object($image) and $image instanceof \SplFileInfo) {
            /** @var \SplFileInfo $image */
            $newPath = self::prepareMoveFile($image->getBaseName(), $model->slug);
            if (!File::copy($image->getRealPath(), $newPath)) {
                throw new \ErrorException(sprintf(
                    'Failed to copy file %s to %s',
                    $image->getRealPath(),
                    $newPath
                ));
            }
            return \ltrim(str_replace(\storage_path('app/public'), '/storage', $newPath), '/');
        }
        return strval($image);
    }
    /**
     * Prepare storage path and return the image full path
     *
     * @param string $filename The basename for the file.
     * @param string $slug     The slug of the game.
     * @return string
     */
    private static function prepareMoveFile(string $filename, string $slug): string
    {
        // * Security filter + beautifier
        $filename = self::sanitizeFileName($filename);
        // * Security filter
        $filename = \filter_var($filename, \FILTER_SANITIZE_STRING);
        // * Slugify filename
        $ext        = \pathinfo($filename, \PATHINFO_EXTENSION);
        $filename   = Str::slug(\pathinfo($filename, \PATHINFO_FILENAME)) . (\strlen($ext) ? ".{$ext}" : '');
        $pathFolder = \storage_path(sprintf('app/public/images/%s', $slug));
        if (!File::exists($pathFolder)) {
            File::makeDirectory($pathFolder, 0755, true);
        }
        $filename = sprintf('%s-%s', Str::uuid(), $filename);
        $fullPath = sprintf('%s/%s', $pathFolder, $filename);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
        return $fullPath;
    }
    /**
     * Sanitize File name for uploaded files
     *
     * @param string  $filename The original uploaded client file name.
     * @param boolean $beautify Beautify the filename.
     * @return string The sanitized file name.
     */
    public static function sanitizeFileName(string $filename, bool $beautify = true): string
    {
        // * Sanitize filename
        // phpcs:disable Generic.Files.LineLength.TooLong
        $filename = preg_replace(
            '~
            [<>:"/\\\|?*]|           # file system reserved https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
            [\x00-\x1F]|             # control characters http://msdn.microsoft.com/en-us/library/windows/desktop/aa365247%28v=vs.85%29.aspx
            [\x7F\xA0\xAD]|          # non-printing characters DEL, NO-BREAK SPACE, SOFT HYPHEN
            [#\[\]@!$&\'()+,;=]|     # URI reserved https://tools.ietf.org/html/rfc3986#section-2.2
            [{}^\~`]                 # URL unsafe characters https://www.ietf.org/rfc/rfc1738.txt
            ~x',
            '-',
            $filename
        );
        // phpcs:enable
        // * Avoids '.' '..' or '.hiddenFiles' .
        $filename = Str::of($filename)->ltrim('.-');
        // * Optional beautification
        if ($beautify) {
            $filename = static::beautifyFilename($filename);
        }
        // * Maximize filename length to 255 bytes http://serverfault.com/a/9548/44086
        /** @var string */
        $extension = pathinfo($filename, \PATHINFO_EXTENSION);
        /** @var string */
        $filename = pathinfo($filename, \PATHINFO_FILENAME);
        $encoding = mb_detect_encoding($filename);
        $encoding = $encoding ? $encoding : null;
        return \mb_strcut(
            $filename,
            0,
            255 - (!empty($extension) ? strlen($extension) + 1 : 0),
            $encoding
        ) . (!empty($extension) ? ".$extension" : '');
    }
    /**
     * Beautify a filename
     *
     * @param string $filename
     * @return string
     */
    private static function beautifyFilename(string $filename): string
    {
        // Reduce consecutive characters.
        $filename = preg_replace([
            // * "file   name.zip" becomes 'file-name.zip'
            '/ +/',
            // * "file___name.zip" becomes 'file-name.zip'
            '/_+/',
            // * "file---name.zip" becomes 'file-name.zip'
            '/-+/'
        ], '-', $filename);
        $filename = preg_replace([
            // * "file--.--.-.--name.zip" becomes "file.name.zip"
            '/-*\.-*/',
            // * "file...name..zip" becomes "file.name.zip"
            '/\.{2,}/'
        ], '.', $filename);
        // Lowercase for windows/unix interoperability http://support.microsoft.com/kb/100625 .
        $filename = mb_strtolower($filename, mb_detect_encoding($filename));
        // * ".file-name.-" becomes "file-name"
        $filename = trim($filename, '.-');
        return $filename;
    }

    /**
     * Asserts that the field is unique
     *
     * @param string        $table
     * @param string        $field
     * @param mixed         $value
     * @param integer|null  $id
     * @param callable|null $query
     * @return void
     * @throws \Illuminate\Validation\ValidationException If the field is not unique.
     */
    public static function assertFieldIsUnique(
        string $table,
        string $field,
        $value,
        ?int $id = null,
        ?callable $query = null
    ) {
        if (!$query) {
            Validator::make([$field => $value], [
                self::mbReplace('.', '\.', $field) => Rule::unique($table, $field)->ignore($id),
            ], [
                self::mbReplace('.', '\.', "{$field}.unique")
                => trans('La valeur :value pour le champ :attribute est déjà utilisé', [
                    'attribute' => $field,
                    'value' => $value
                ])
            ])->validate();
            return;
        }
        Validator::make([$field => $value], [
            $field => Rule::unique($table)->where($query)->ignore($id),
        ], [
            $field . '.unique' => trans('La valeur pour le champ :attribute est déjà utilisé', [
                'attribute' => $field
            ])
        ])->validate();
    }

    /**
     * Mutltibyte string replace
     * @param mixed   $search
     * @param mixed   $replace
     * @param mixed   $subject
     * @param integer $count
     * @return mixed
     */
    public static function mbReplace($search, $replace, $subject, int &$count = 0)
    {
        if (!is_array($search) && is_array($replace)) {
            return false;
        }
        if (is_array($subject)) {
            // Call mb_replace for each single string in $subject .
            foreach ($subject as &$string) {
                $string = &self::mbReplace($search, $replace, $string, $count);
            }
        } elseif (is_array($search)) {
            if (!is_array($replace)) {
                foreach ($search as &$string) {
                    $subject = self::mbReplace($string, $replace, $subject, $count);
                }
            } else {
                $n = max(count($search), count($replace));
                while ($n--) {
                    $subject = self::mbReplace(current($search), current($replace), $subject, $count);
                    next($search);
                    next($replace);
                }
            }
        } else {
            $parts   = mb_split(preg_quote($search), $subject);
            $count   = count($parts) - 1;
            $subject = implode($replace, $parts);
        } //end if
        return $subject;
    }
}
