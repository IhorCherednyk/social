<?php

namespace app\helpers;

use Yii;
use yii\web\UploadedFile;

class ImageHelper {

    const NEW_IMAGE_MAX_WIDTH = 200;
    const NEW_IMAGE_MAX_HEIGHT = 200;

    public static function saveImage($model) {


        // проверяем является ли $file экземплояром класса UploadedFile
        if ($model->file instanceof UploadedFile) {

            $model->file = self::resizeImage($model->file);

            self::deleteCurentImage($model->avatar_path);


            $basePath = Yii::getAlias('@webroot');
            //Берем нашу картинку добовляем к ней время и переводим ее в вид md5 
            $baseName = md5($model->file->baseName . time());

            // Создаем путь к нашей картинке 
            $dir = '/' . 'img' . '/' . substr($baseName, 0, 2) . '/' . substr($baseName, 2, 2);

            if (!is_dir($basePath . $dir)) {
                $oldmask = umask(0);
                mkdir($basePath . $dir, 0777, true);
                umask($oldmask);
            }

            // И сохраняем наш файл на сервер и возвращаем этот путь что бы записать его в базу 

            if ($model->file->saveAs($basePath . $dir . '/' . $baseName . '.' . $model->file->extension)) {

                return $dir . '/' . $baseName . '.' . $model->file->extension;
            }
        }
        return false;
    }

    public static function resizeImage($image) {

        switch ($image->extension) {
            case 'png':
                $source = imagecreatefrompng($image->tempName);
                break;
            case 'jpg':
                $source = imagecreatefromjpeg($image->tempName);
                break;
            case 'jpeg':
                $source = imagecreatefromjpeg($image->tempName);
                break;
        }
        $currentImageSize = getimagesize($image->tempName);
        $currentImageWidth = $currentImageSize[0];
        $currentImageHeight = $currentImageSize[1];
        $currentAspectRatio = $currentImageWidth / $currentImageHeight;


        $newAspectRatio = self::NEW_IMAGE_MAX_WIDTH / self::NEW_IMAGE_MAX_HEIGHT;

        if ($currentImageWidth <= self::NEW_IMAGE_MAX_WIDTH && $currentImageHeight <= self::NEW_IMAGE_MAX_HEIGHT) {
            $create_image_width = $currentImageWidth;
            $create_image_height = $currentImageHeight;
        } elseif ($newAspectRatio > $currentAspectRatio) {
            $create_image_width = (int) (self::NEW_IMAGE_MAX_HEIGHT * $currentAspectRatio);
            $create_image_height = self::NEW_IMAGE_MAX_HEIGHT;
        } else {
            $create_image_width = self::NEW_IMAGE_MAX_WIDTH;
            $create_image_height = (int) (self::NEW_IMAGE_MAX_WIDTH / $currentAspectRatio);
        }

        //Create a new true color image
        $newImage = imagecreatetruecolor($create_image_width, $create_image_height);

        //Create a new image from file 
        //Copy and resize part of an image with resampling
        //Output image to file
        switch ($image->extension) {
            case 'png':
                
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparentindex = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefill($newImage, 0, 0, $transparentindex);
                break;
            case 'jpg':
                imagecopyresampled($newImage, $source, 0, 0, 0, 0, $create_image_width, $create_image_height, $currentImageWidth, $currentImageHeight);
                imagejpeg($newImage, $image->tempName, 90);
                break;
            case 'jpeg':
                imagecopyresampled($newImage, $source, 0, 0, 0, 0, $create_image_width, $create_image_height, $currentImageWidth, $currentImageHeight);
                imagejpeg($newImage, $image->tempName, 90);
                break;
        }

        //set rights on image file
        chmod($image->tempName, 0777);
        //return crop image

        return $image;
    }

    public static function deleteCurentImage($img) {
        if (null !== $img && file_exists(\Yii::getAlias('@webroot') . $img)) {
            unlink(\Yii::getAlias('@webroot') . $img);
        }
    }

}

?>