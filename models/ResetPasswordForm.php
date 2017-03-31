<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.08.2015
 * Time: 15:46
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

class ResetPasswordForm extends Model
{
    public $password;
    private $_user;

    public function rules()
    {
        return [
            ['password', 'required']
        ];
    }


    public function resetPassword($token)
    {
        /* @var $user User */
        $user = User::findById($token->user_id);
        $user->setPassword($this->password);
        $user->password = $this->password;
        if($user->save()){
            $token->delete();
            return true;
        }
        return false;
    }

}