<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170304_103327_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'password' => $this->string(),
            'login' => $this->string(),
            'email' => $this->string(),
            'name' => $this->string(),
            'sername' => $this->string(),
            'role' => $this->boolean(),
            'auth_key' => $this->string(),
            'last_login_date' => $this->timestamp(),
        ]);
        
        $this->insert('user', [
            'password' =>  \Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'login' => 'admin',
            'email' => 'am@mail.ru',
            'name' => 'ihor',
            'sername' => 'cc',
            'role' => '1',
            'auth_key' => '',
            'last_login_date' => '',
        ]);
    }
    
 
    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
