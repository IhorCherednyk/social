<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    // Сюда мы получаем все что пришло нам из view из нашей формы
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;
    
    public function rules()
    {
        //Попадаем сюда из метода login() cтр.37
        // Смотрим что помимо обычной валидации у нас еще указанно что password должен пройти уникальную
        // валидацию в методе validatePassword переходим в нее
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
        // если валидация прошла успешно возвраащем true и переходим обратно в Login()
        // или мы получили false то мы возвращаем ошибку
    }
    
    //Переходим сюда из  rules()
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) { // Здесь мы проверяем нет ли ошибок валидации от предидущих полей
            $user = $this->getUser(); // Получаем пользователя из базы переходим в функцию getUser() стр 49 loginform.php
 
            // После того как мыполчил обьект юзера далее мы проверяем
            // 1)!$user  -- проверяет если такого пользователя нет то просто $user вернет нам false с поощью !$user  получим true
            // 2)!$user->validatePassword($this->password) --  во второй проверки  в this мы получаем то что передали в нашей форме следовательно 
            // мы можем получить от туда пароль и тогда мы обращаемся к  User.php и его методу validatePassword в эту валидацию мы помещаем
            // веденный пользователем пароль и сравниваем его с паролем который хрнаится у нас в базе под этим юзером
            // если хоть нибудь вернет true то мы вернем ошибку $this->addError($attribute, 'Incorrect username or password.');
            // ВОПРОС 1 можно написать так как ниже и не писать еще один метод в юзере
            // Вопрос 2  if (!$user || !$user->validatePassword($this->password)) { можно вместо или написть &&
            //            ($user->password != $this->password)? true: false {
            //                
            //            } ????????????????????????????????????????????????????????
            
            
            if (!$user || !$user->validatePassword($this->password)) {
                //здесь мы передаем ошибку
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
        
        //    после этого мы возвращаем ответ в rules
    }
    //2. Попадаем сюда и первым делом что мы делаем это проверяем валидацию
    //   отправляемся на строку 18 
    public function login()
    {
        if ($this->validate()) { // Здесь мы отправляемся в валидацию rules()
            // Если валидация прошл успешно то далее мы
            // и так если все прошло хорошо 
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        // Если валидация прошла не успешно мы возвращаем false 
        return false;
    }

    // Попадаем сюда из validatePassword() что бы проверить существет ли юзер в базе
    public function getUser()
    {
        // Если юзер не задан мы используем статический метод из Uesr.php findByUsername и передаем
        // в него точто вернет нам из формы username и отправляемьс в User.php метод findByUsername()
        // проверка на случай если ввели правильно login но неправильно пароль что бы заново не тянуть из базы юзера
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        //  и возвраащем обьект нашего юзера в validatePassword()
        return $this->_user;
    }
}
