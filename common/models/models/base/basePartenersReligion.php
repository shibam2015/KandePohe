<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_religion".
 *
 * @property integer $iPartners_Religion_ID
 * @property integer $iUser_ID
 * @property integer $iReligion_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class basePartenersReligion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_religion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iReligion_ID'], 'required'],
            [['iUser_ID', 'iReligion_ID'], 'integer'],
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
            'iReligion_ID' => 'I Religion  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
