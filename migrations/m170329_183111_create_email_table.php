<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message`.
 */
class m170329_183111_create_email_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('email', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->defaultValue(0),
            'type' => $this->integer()->notNull(),
            'recipient_email' => $this->string()->notNull(),
            'data' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('email');
    }
}
