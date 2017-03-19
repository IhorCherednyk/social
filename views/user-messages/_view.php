<?php

use app\models\Message;
use app\models\User;
use yii\web\View;


/* @var $this View */
/* @var $model User */

?>


<span class="message-text"><?php echo $model->text ;?></span>
<?php 
   if($incomingMessage == Message::MESSAGE_INCOMING):
?>
<span class="message-sender"><?= $model->sender_id ?> </span>
        <?php else:?>
<span class="message-sender"><?= $model->recipient_id ?> </span>
<?php endif;?>




