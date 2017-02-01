<?php

namespace common\models;
use Yii;

/**
 * This is the model class for table "partner_working_with".
 *
 * @property integer $iPartner_Working_ID
 * @property integer $iUser_ID
 * @property integer $iWorking_With_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnerWorkingWith extends \common\models\base\basePartnerWorkingWith
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_working_with';
    }

    public static function findByUserId($UserID)
    {

        return static::findOne(['iUser_ID' => $UserID]);
    }

    public static function findAllByUserId($UserID)
    {

        return static::findAll(['iUser_ID' => $UserID]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iWorking_With_ID'], 'required'],
            [['iUser_ID', 'iWorking_With_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartner_Working_ID' => 'I Partner  Working  ID',
            'iUser_ID' => 'I User  ID',
            'iWorking_With_ID' => 'Working With',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public function getWorkingWithName()
    {
        return $this->hasOne(WorkingWith::className(), ['iWorkingWithID' => 'iWorking_With_ID']);
    }
}
