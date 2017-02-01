<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner_working_as".
 *
 * @property integer $ID
 * @property integer $iUser_ID
 * @property integer $iWorking_As_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnerWorkingAs extends \common\models\base\basePartnerWorkingAs
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_working_as';
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
            [['iUser_ID', 'iWorking_As_ID'], 'required'],
            [['iUser_ID', 'iWorking_As_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'iUser_ID' => 'I User  ID',
            'iWorking_As_ID' => 'Working As',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public function getWorkingAsName()
    {
        return $this->hasOne(WorkingAS::className(), ['iWorkingAsID' => 'iWorking_As_ID']);
    }
}
