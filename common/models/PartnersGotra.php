<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_gotra".
 *
 * @property integer $iPartners_Gotra_ID
 * @property integer $iUser_ID
 * @property integer $iGotra_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnersGotra extends \common\models\base\basePartnersGotra
{

    public static function findByUserId($UserId)
    {

        return static::findOne(['iUser_ID' => $UserId]);
    }

    public static function findAllByUserId($UserId)
    {

        return static::findAll(['iUser_ID' => $UserId]);
    }

    public function rules()
    {
        return [
            //[['iUser_ID', 'iGotra_ID'], 'required'],
            // [['iUser_ID', 'iGotra_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Gotra_ID' => 'I Partners  Gotra  ID',
            'iUser_ID' => 'I User  ID',
            'iGotra_ID' => 'Gotra',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public function getGotraName()
    {
        return $this->hasOne(MasterGotra::className(), ['iGotraID' => 'iGotra_ID']);
    }
}
