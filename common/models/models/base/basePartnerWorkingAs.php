<?php

namespace common\models\base;

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
class basePartnerWorkingAs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_working_as';
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
            'iWorking_As_ID' => 'I Working  As  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
