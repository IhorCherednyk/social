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
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'status' => $this->integer()->defaultValue(1),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'role' => $this->integer()->defaultValue(3),
            'last_login_date' => $this->integer()->notNull(),
            'email_activation_key' =>$this->string()->notNull()
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
