<?php

namespace common\models\base;

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
class basePartnerWorkingWith extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_working_with';
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
            'iWorking_With_ID' => 'I Working  With  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
