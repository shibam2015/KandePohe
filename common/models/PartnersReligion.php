<?php

namespace common\models;

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
class PartnersReligion extends \common\models\base\basePartnersStates
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_religion';
    }

    public static function findByUserId($userid)
    {
        return static::findOne(['iUser_ID' => $userid]);
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
            'iPartners_Religion_ID' => 'Partners  Religion  ID',
            'iUser_ID' => 'User  ID',
            'iReligion_ID' => 'Religion  ID',
            'dtCreated' => 'Created',
            'dtModified' => 'Modified',
        ];
    }
}
