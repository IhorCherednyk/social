<?php

namespace app\helpers;

use Yii;
use yii\helpers\Html;

/**
 * Description of FilterHelper
 *
 * @author Stableflow
 */
class FilterHelper {

    public static function dateRange($searchModel, $attributeFrom, $attributeTo, $format = 'yyyy-mm-dd') {
        $modelName = explode('\\', get_class($searchModel));
        $inputFrom = Html::textInput(end($modelName) . "[$attributeFrom]", $searchModel->{$attributeFrom}, ['class' => 'form-control form-filter input-sm', 'readonly' => '', 'placeholder' => Yii::t('app', 'From')]);
        $inputTo = Html::textInput(end($modelName) . "[$attributeTo]", $searchModel->{$attributeTo}, ['class' => 'form-control form-filter input-sm', 'readonly' => '', 'placeholder' => Yii::t('app', 'To')]);
        return "<div class = \"input-group date date-picker margin-bottom-5\" data-date-format = \"yyyy-mm-dd\">
                    $inputFrom
                    <span class = \"input-group-btn\">
                        <button class = \"btn btn-sm default\" type = \"button\"><i class = \"fa fa-calendar\"></i></button>
                    </span>
                </div>
                <div class = \"input-group date date-picker\" data-date-format = \"yyyy-mm-dd\">
                    $inputTo
                    <span class = \"input-group-btn\">
                        <button class = \"btn btn-sm default\" type = \"button\"><i class = \"fa fa-calendar\"></i></button>
                    </span>
                </div>";
    }

    public static function textRange($searchModel, $attributeFrom, $attributeTo) {
        $modelName = explode('\\', get_class($searchModel));
        $inputFrom = Html::textInput(end($modelName) . "[$attributeFrom]", $searchModel->{$attributeFrom}, ['class' => 'form-control form-filter input-sm', 'placeholder' => Yii::t('app', 'From')]);
        $inputTo = Html::textInput(end($modelName) . "[$attributeTo]", $searchModel->{$attributeTo}, ['class' => 'form-control form-filter input-sm', 'placeholder' => Yii::t('app', 'To')]);
        return "<div class = \"input-group margin-bottom-5\" >
                    $inputFrom
                    
                </div>
                <div class = \"input-group\">
                    $inputTo
                    
                </div>";
    }

    public static function singleField($searchModel, $attribute) {
        $modelName = explode('\\', get_class($searchModel));
        $inputFrom = Html::textInput(end($modelName) . "[$attribute]", $searchModel->{$attribute}, ['class' => 'form-control form-filter input-sm']);
        return "<div class = \"input-group margin-bottom-5\" >
                    $inputFrom
                    
                </div>";
    }

}
