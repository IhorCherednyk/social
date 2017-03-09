<?php

namespace app\helpers;
use yii\web\UploadedFile;

class ImageUpload {
    
    public static function saveImage($file){
        if(!is_null($file)){
            $path = \Yii::getAlias('@web') . 'img/' . $file->name;
            jd2
            $file->saveAs($path);
            
            return '/' . $path;
        }
        return false;
    }
    
}
