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
    }
 
    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
