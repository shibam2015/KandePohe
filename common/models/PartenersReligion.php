<?php

namespace common\models;

use Yii;

class PartenersReligion extends \common\models\base\basePartenersReligion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['iUser_ID', 'iReligion_ID'], 'required'],
            // [['iUser_ID', 'iReligion_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Religion_ID' => 'I Partners  Religion  ID',
            'iUser_ID' => 'I User  ID',
            'iReligion_ID' => 'Religion',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public static function findByUserId($userid)
    {

        return static::findOne(['iUser_ID' => $userid]);
    }

    public function getReligionName()
    {
        return $this->hasOne(Religion::className(), ['iReligion_ID' => 'iReligion_ID']);
    }
}
