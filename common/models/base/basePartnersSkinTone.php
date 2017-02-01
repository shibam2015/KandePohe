<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_skin_tone".
 *
 * @property integer $iPartners_Skin_Tone_ID
 * @property integer $iUser_ID
 * @property integer $iSkin_Tone_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class basePartnersSkinTone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_skin_tone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iSkin_Tone_ID'], 'required'],
            [['iUser_ID', 'iSkin_Tone_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Skin_Tone_ID' => 'I Partners  Skin  Tone  ID',
            'iUser_ID' => 'I User  ID',
            'iSkin_Tone_ID' => 'I Skin  Tone  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
