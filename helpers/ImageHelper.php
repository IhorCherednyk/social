<?php

namespace app\helpers;

use Yii;
use yii\web\UploadedFile;

class ImageHelper {

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
        $currentImageSize = getimagesize($image->tempName);
        $curentWidth = $currentImageSize[0];
        $curentHeight = $currentImageSize[1];
        $newImageWidth = 200;
        $newImageHeight = 200;
        //Create a new true color image
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);

        //Create a new image from file 
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
        
        //Copy and resize part of an image with resampling
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $curentWidth, $curentHeight);
        //Output image to file
        imagejpeg($newImage, $image->tempName, 90);
        //set rights on image file
        chmod($image->tempName, 0777);
        //return crop image
        
        return $image;
    }
    
    public static function deleteCurentImage($img){
        if (null !== $img && file_exists(\Yii::getAlias('@webroot') . $img)) {
            unlink(\Yii::getAlias('@webroot') . $img);
        }
    }

}
