<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $ads_id
 * @property int $created_at
 *
 * @property Ads $ads
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ads_id'], 'required']
        ];
    }
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ],
            ],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasOne(Ads::className(), ['id' => 'ads_id']);
    }
}
