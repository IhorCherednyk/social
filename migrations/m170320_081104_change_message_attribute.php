<?php

use yii\db\Migration;

class m170320_081104_change_message_attribute extends Migration
{
    public function up()
    {
        $this->dropColumn( '{{%message}}', 'date_created');
        $this->addColumn('{{%message}}', 'created_at', $this->integer(11));
        $this->addColumn('{{%message}}', 'updated_at', $this->integer(11));
    }

    public function down()
    {
        $this->addColumn( '{{%message}}', 'date_created', $this->integer(11));
        $this->dropColumn('{{%message}}', 'created_at');
        $this->dropColumn('{{%message}}', 'updated_at');

       
    }

}
