<?php

namespace common\models\base;

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
class basePartnersGotra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_gotra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iGotra_ID'], 'required'],
            [['iUser_ID', 'iGotra_ID'], 'integer'],
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
            'iGotra_ID' => 'I Gotra  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
