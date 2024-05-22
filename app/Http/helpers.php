<?php

use Illuminate\Support\Carbon;

/**
 * To return S3 file path
 *
 * @param $fileName
 * @param $filePath
 * @return string
 */
function getS3FilePath($fileName, $filePath)
{
    if (!empty($fileName)) {
        return 'https://' . \Storage::disk('s3')->getAdapter()->getClient()->getendPoint()->getHost() . '/' . \Storage::disk('s3')->getAdapter()->getBucket() . $filePath . $fileName;
    }
    return defaultAvatarFile();
}

function defaultAvatarFile(): string
{
    return asset("/assets/img/default.jpg");
}


function uploadToS3($file, $destination)
{
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    \Storage::disk('s3')->put($destination . '/' . $filename, file_get_contents($file));
    return $filename;
}

function ttlForListAPIs()
{
   return Carbon::now()->addHour()->toDateTimeString();
}
