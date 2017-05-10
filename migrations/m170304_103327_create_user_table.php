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
        
        $this->insert('user', [
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password_hash' => '$2y$13$LBE37uFP4mxAq1J53aEuuensq53IpzqQGnw5b6uyQWhKyWLo1Z.Ra', //admin
            'status' => app\models\User::STATUS_ACTIVE,
            'auth_key' => 'ttkSM5nhi48mcRQ_N4mCumIPXy9XAtXw',
            'created_at' => '1494427262',
            'updated_at' => '1494427262',
            'role' => app\models\User::IS_ADMIN,
            'last_login_date' => '0',
            'email_activation_key' => 'GIoYdW'
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
