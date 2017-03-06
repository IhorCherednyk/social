<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `user`
 */
class m170304_113925_create_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'status' => $this->boolean(),
            'date_created' => $this->timestamp(),
            'sender_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `sender_id`
        $this->createIndex(
            'idx-message-sender_id',
            'message',
            'sender_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-message-sender_id',
            'message',
            'sender_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `recipient_id`
        $this->createIndex(
            'idx-message-recipient_id',
            'message',
            'recipient_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-message-recipient_id',
            'message',
            'recipient_id',
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
            'fk-message-sender_id',
            'message'
        );

        // drops index for column `sender_id`
        $this->dropIndex(
            'idx-message-sender_id',
            'message'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-message-recipient_id',
            'message'
        );

        // drops index for column `recipient_id`
        $this->dropIndex(
            'idx-message-recipient_id',
            'message'
        );

        $this->dropTable('message');
    }
}
