<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/**
 * To return S3 file path
 *
 * @param $fileName
 * @param $filePath
 * @return string
 */
function getS3FilePath($fileName, $filePath): string
{
    if (!empty($fileName)) {
        return 'https://' . \Storage::disk('s3')->getAdapter()->getClient()->getendPoint()->getHost() . '/' . \Storage::disk('s3')->getAdapter()->getBucket() . $filePath . $fileName;
    }
    return defaultAvatarFile();
}

/**
 * To get the default avatar
 *
 * @return string
 */
function defaultAvatarFile(): string
{
    return asset("/assets/img/default.jpg");
}

/**
 * To upload a file to s3
 *
 * @param $file
 * @param $destination
 * @return string
 */
function uploadToS3($file, $destination): string
{
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    \Storage::disk('s3')->put($destination . '/' . $filename, file_get_contents($file));
    return $filename;
}

/**
 * To get ttl for list APIs
 *
 * @return string
 */
function ttlForListAPIs(): string
{
    return Carbon::now()->addMinutes(LIST_API_TTL)->toDateTimeString();
}

/**
 * Get the current route name.
 *
 * @return string|null
 */
function routeName(): ?string
{
    return Route::currentRouteName();
}
