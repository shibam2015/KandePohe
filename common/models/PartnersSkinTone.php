<?php

namespace common\models;

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
class PartnersSkinTone extends \common\models\base\basePartnersSkinTone
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_skin_tone';
    }

    public static function findAllByUserId($UserId)
    {

        return static::findAll(['iUser_ID' => $UserId]);
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
            'iPartners_Skin_Tone_ID' => 'Partners Skin Tone ID',
            'iUser_ID' => 'User ID',
            'iSkin_Tone_ID' => 'Skin Tone ID',
            'dtCreated' => 'Date Created',
            'dtModified' => 'Date Modified',
        ];
    }


}
