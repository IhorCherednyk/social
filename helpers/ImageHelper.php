<?php

namespace app\helpers;

use Yii;
use yii\web\UploadedFile;

class ImageHelper {

    public static function saveImage($file) {
        
        // проверяем является ли $file экземплояром класса UploadedFile
        if ($file instanceof UploadedFile) {
            //получаем путь к папке web
            $basePath = Yii::getAlias('@webroot');
            
            
            //Берем нашу картинку добовляем к ней время и переводим ее в вид md5 
            $baseName = md5($file->baseName . time());
            
            // Создаем путь к нашей картинке 
            $dir = '/' . 'img' . '/' . substr($baseName, 0, 2) . '/' . substr($baseName, 2, 2);
            
            if (!is_dir($basePath . $dir)) {
                $oldmask = umask(0);
                mkdir($basePath . $dir, 0777, true);
                umask($oldmask);
            }

            // И сохраняем наш файл на сервер и возвращаем этот путь что бы записать его в базу 
            
            if ($file->saveAs($basePath . $dir . '/' . $baseName . '.' . $file->extension)) {
                return $dir . '/' . $baseName . '.' . $file->extension;
            }
        }
        return false;
    }

}
