<?php

namespace common\components\helpers;

use Yii;

class ImageHelper
{
    const DIR_CACHE = '@image/cache/';
    const DIR_ORIGINAL = '@image/original/';

    public function resize($filename, $width, $height)
    {
        $dir_cache = Yii::getAlias(self::DIR_CACHE);
        $dir_original = Yii::getAlias(self::DIR_ORIGINAL);
        if (!is_file($dir_original.$filename)) {
            $filename = 'no_image.png';
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_old = $filename;
        $image_new = mb_substr($filename, 0, mb_strrpos($filename, '.')).'-'.$width.'x'.$height.'.'.$extension;

        if (!is_file($dir_cache.$image_new) || (filectime($dir_original.$image_old) > filectime($dir_cache.$image_new))) {
            list($width_orig, $height_orig, $image_type) = getimagesize($dir_original.$image_old);

            if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) {
                return $dir_original.$image_old;
            }

            $path = '';

            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path.$directory;

                if (!is_dir($dir_cache.$path)) {
                    mkdir($dir_cache.$path, 0777);
                }
            }

            if ($width_orig != $width || $height_orig != $height) {
                $image = new Image($dir_original.$image_old);
                $image->resize($width, $height);
                $image->save($dir_cache.$image_new);
            } else {
                copy($dir_original.$image_old, $dir_cache.$image_new);
            }
        }

        return Yii::$app->urlFrontendManager->createAbsoluteUrl('images/cache/'.$image_new);
    }
}
