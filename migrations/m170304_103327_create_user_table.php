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
            'status' => $this->boolean(),
            'last_login_date' => $this->timestamp(),
        ]);
        
        $this->insert('user', [
            'password' => 'admin',
            'login' => 'admin',
            'email' => 'am@mail.ru',
            'name' => 'ihor',
            'sername' => 'cc',
            'role' => '1',
            'status' => '0',
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
