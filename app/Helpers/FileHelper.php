<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileHelper
{
    /**
    * Get file extension.
    *
    * @param $file
    *
    * @return mixed
    */
    public static function getExtension($file)
    {
        return $file->getClientOriginalExtension();
    }

    /**
    * Get file original name.
    *
    * @param $file
    *
    * @return mixed
    */
    public static function getOriginalName($file)
    {
        return $file->getClientOriginalName();
    }

    /**
    * Storage file.
    *
    * @param $file
    *
    * @return mixed
    */
    public static function storage($file)
    {
        try {
            $dataFile = file_get_contents($file);
            $filePath = IMG_DIR . time() . '_' . static::getOriginalName($file);
            Storage::disk(env(ENV_FILE_SYSTEMS))->put($filePath, $dataFile, 'public');
        } catch (\Exception $exception) {
            Log::error('[UploadFile]: ' . $exception->getMessage());
            $filePath = null;
        }

        return $filePath;
    }

    /**
     * Delete file.
     *
     * @param string $path
     *
     * @return void
     */
    public static function delete(string $path)
    {
        if (Storage::disk(env(ENV_FILE_SYSTEMS))->exists($path)) {
            Storage::disk(env(ENV_FILE_SYSTEMS))->delete($path);
        }
    }
}
