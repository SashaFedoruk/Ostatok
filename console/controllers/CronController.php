<?php

namespace console\controllers;

use common\models\Notifications;
use Yii;
use yii\console\Controller;
use yii\helpers\Url;

/**
 * Test controller
 */
class CronController extends Controller {


    public function actionSendNotifications(){

        $this->layout = "";

        //echo $this->sendNotificationsByDay(0)." ";
        //echo $this->sendNotificationsByDay(4)." ";
        echo $this->sendNotificationsByDay(3)." ";
        echo $this->sendNotificationsByDay(7);
        return "Ok";
    }

    private function sendNotificationsByDay($days){
        $notifications = Notifications::find()->where(['=', 'DATEDIFF(NOW(), FROM_UNIXTIME(created_at))', $days])->all();
        foreach ($notifications as $el){
            if($el->ads->status != 1){
                continue;
            }
            $emailAdress = $el->ads->user->email;

            $url = "http://ostatok.online/frontend/web/index.php?r=site%2Fall-active-ads&adsId=".$el->ads->id;
            //$emailAdress = "sasha1.fedoruk@gmail.com";
            $text = "
            <h3>Здравствуйте, ".$el->ads->user->firstname."</h3>
            <p>Вы уже продали свой остаток товара <b>".$el->ads->product->name."</b> (".$el->ads->width."x".$el->ads->length.")?</p>
            <p>Если данное обьявления уже не актуально, удалите пожалуйста ваше обьявления перейдя по данной ссылке: $url</p>
            <br>
            <p>С уважением,<br> Служба поддержки http://ostatok.online</p>
            
            ";

            Yii::$app->mailer->compose()
                ->setTo($emailAdress)
                ->setFrom("support@ostatok.online")
                ->setSubject("Вы уже продали свой остаток товара ".$el->ads->product->name." (".$el->ads->width."x".$el->ads->length.")?")
                ->setHtmlBody($text)
                ->send();
            if($days == 7){
                $el->delete();
            }
        }
        return count($notifications);
    }

    public function actionIndex() {
        echo "cron service runnning";
    }

    public function actionMail($to) {
        echo "Sending mail to " . $to;
    }

}