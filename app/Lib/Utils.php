<?php

namespace App\Lib;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Some utilities methods
 */
class Utils
{
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
        $table = $model->getTable();
        if (\is_object($image) and $image instanceof \Illuminate\Http\UploadedFile) {
            /** @var \Illuminate\Http\UploadedFile $image */
            $newPath = self::prepareMoveFile($table, $image->getClientOriginalName());
            $newPath = str_replace(storage_path('app'), '', $newPath);
            $image->storePubliclyAs(
                pathinfo($newPath, \PATHINFO_DIRNAME),
                pathinfo($newPath, \PATHINFO_BASENAME)
            );
            return 'storage' . str_replace('/public', '', $newPath);
        }
        if (\is_object($image) and $image instanceof \SplFileInfo) {
            /** @var \SplFileInfo $image */
            $newPath = self::prepareMoveFile($table, $image->getBaseName());
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
     * @param string $table    Model table name.
     * @param string $filename The basename for the file.
     * @return string
     */
    private static function prepareMoveFile(string $table, string $filename): string
    {
        // * Security filter + beautifier
        $filename = self::sanitizeFileName($filename);
        // * Security filter
        $filename = \filter_var($filename, \FILTER_SANITIZE_STRING);
        // * Slugify filename
        $ext        = \pathinfo($filename, \PATHINFO_EXTENSION);
        $filename   = Str::slug(\pathinfo($filename, \PATHINFO_FILENAME)) . (\strlen($ext) ? ".{$ext}" : '');
        $pathFolder = \storage_path(sprintf('app/public/images/%s', $table));
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
}
