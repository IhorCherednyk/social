<?php

use yii\db\Migration;

/**
 * Handles the creation of table `token`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m170304_113044_create_token_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('token', [
            'id' => $this->primaryKey(),
            'secret_key' => $this->string(32)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'expire_date' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-token-user_id',
            'token',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-token-user_id',
            'token',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-token-user_id',
            'token'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-token-user_id',
            'token'
        );

        $this->dropTable('token');
    }
}
