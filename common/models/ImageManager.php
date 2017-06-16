<?php

namespace common\models;

use yii\base\Model;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;
use Yii;

class ImageManager extends Model
{
    public $files;
    public static $imagePath = '@image/original/';
    public static $cachePath = '@image/cache/';

    public function rules()
    {
        return [
           [['files'], 'image', 'maxFiles' => 0],
        ];
    }

    public function upload($dir)
    {
        if ($this->validate()) {
            $dir = self::$imagePath.$dir;
            $dir = rtrim($dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
            $dir = Yii::getAlias($dir);

            foreach ($this->files as $file) {
                $file->saveAs($dir.$file->baseName.'.'.$file->extension);
            }

            return true;
        } else {
            return false;
        }
    }

    public static function remove($paths)
    {
        $imagePath = rtrim(Yii::getAlias(self::$imagePath)).DIRECTORY_SEPARATOR;
        $cachePath = rtrim(Yii::getAlias(self::$cachePath)).DIRECTORY_SEPARATOR;
        foreach ($paths as $path) {
            if (is_dir($imagePath.$path)) {
                BaseFileHelper::removeDirectory($imagePath.$path);

                //remove cache dir
                BaseFileHelper::removeDirectory($cachePath.$path);
            } else {
                unlink($imagePath.$path);

                //remove cache file
                $index = stripos(strrev($cachePath.$path), '.') + 1;
                $file = substr_replace($cachePath.$path, '-*', -$index, -$index);
                $caches = glob($file, GLOB_BRACE);

                if ($caches) {
                    foreach ($caches as $cache) {
                        unlink($cache);
                    }
                }
            }
        }

        return true;
    }

    public static function find($dir, $filter_name)
    {
        $imagePath = Yii::getAlias(rtrim(self::$imagePath, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR);
        $dir = self::$imagePath.$dir;
        $dir = rtrim($dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $dir = Yii::getAlias($dir);

        if (!is_dir($dir)) {
            throw new InvalidParamException("The dir argument must be a directory: $dir");
        }

        $list = [];

        $files = glob($dir.$filter_name.'*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

        if (!$files) {
            $files = [];
        }

        $dirs = glob($dir.$filter_name.'*', GLOB_ONLYDIR);

        if (!$dirs) {
            $dirs = [];
        }

        $arr = array_merge($dirs, $files);

        foreach ($arr as $path) {
            $name = basename($path);
            $type = is_dir($path) ? 'directory' : 'image';
            $path = str_replace($imagePath, '', $path);
            $href = is_dir($dir.$path) ? Url::to(['image-manager/index', 'directory' => $path]) : \Yii::$app->urlFrontendManager->createAbsoluteUrl('images/original/'.$path);

            $list[] = [
                'name' => $name,
                'path' => $path,
                'type' => $type,
                'href' => $href,
                'thumb' => $type == 'image' ? $path : '',
            ];
        }

        return $list;
    }

    public static function createDirectory($dir, $folder)
    {
        $dir = self::$imagePath.$dir;
        $dir = rtrim($dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $dir = Yii::getAlias($dir);

        if (is_dir($dir)) {
            return false;
        }

        return BaseFileHelper::createDirectory($dir.$folder);
    }
}
