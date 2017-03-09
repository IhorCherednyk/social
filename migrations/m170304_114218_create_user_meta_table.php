<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_meta`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m170304_114218_create_user_meta_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_meta', [
            'id' => $this->primaryKey(),
            'hobbies' => $this->string(),
            'lovely_films' => $this->string(),
            'lovely_book' => $this->string(),
            'avatar_path' => $this->string(),
            'first_name' => $this->string()->notNull(32),
            'last_name' => $this->string()->notNull(32),
            'user_id' => $this->integer(),
            'birthday' => $this->integer()
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_meta-user_id',
            'user_meta',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_meta-user_id',
            'user_meta',
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
            'fk-user_meta-user_id',
            'user_meta'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_meta-user_id',
            'user_meta'
        );

        $this->dropTable('user_meta');
    }
}
