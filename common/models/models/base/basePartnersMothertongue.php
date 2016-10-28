<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_mothertongue".
 *
 * @property integer $iPartners_Mothertongue_ID
 * @property integer $iUser_ID
 * @property integer $iMothertongue_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class basePartnersMothertongue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_mothertongue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iMothertongue_ID'], 'required'],
            [['iUser_ID', 'iMothertongue_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Mothertongue_ID' => 'I Partners  Mothertongue  ID',
            'iUser_ID' => 'I User  ID',
            'iMothertongue_ID' => 'I Mothertongue  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
