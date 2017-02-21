<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_nakshtra".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $nakshtra_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersNakshtra extends \common\models\base\basePartnersNakshtra
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_nakshtra';
    }

    public static function findByUserId($userid)
    {

        return static::findOne(['user_id' => $userid]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['user_id', 'nakshtra_id'], 'required'],
            [['user_id', 'nakshtra_id'], 'integer'],
            [['is_partner_preference'], 'string'],
            [['created_on', 'modified_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'user_id' => 'User ID',
            'nakshtra_id' => 'Nakshtra',
            'is_partner_preference' => 'Is Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getNakshtraName()
    {
        return $this->hasOne(Nakshtra::className(), ['ID' => 'nakshtra_id']);
    }
}
