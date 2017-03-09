<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_meta".
 *
 * @property integer $id
 * @property string $hobbies
 * @property string $lovely_films
 * @property string $lovely_book
 * @property string $avatar_path
 * @property string $first_name
 * @property string $last_name
 * @property integer $user_id
 * @property integer $birthday
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['user_id', 'birthday'], 'integer'],
            [['hobbies', 'lovely_films', 'lovely_book', 'avatar_path', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function updateProfile()
    {
        $profile = ($profile = Profile::findOne(Yii::$app->user->id)) ? $profile : new Profile(); //если профайл есть редактируем если нет создаем
        $profile->user_id = Yii::$app->user->id;
        $profile->setAttributes($this->attributes);
        
        return $profile->save() ? true : false;
    }
}
