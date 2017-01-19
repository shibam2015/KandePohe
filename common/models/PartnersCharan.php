<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_charan".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $charan_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersCharan extends \common\models\base\basePartnersCharan
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_charan';
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
            [['user_id', 'charan_id'], 'required'],
            [['user_id', 'charan_id'], 'integer'],
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
            'charan_id' => 'Charan',
            'is_partner_preference' => 'Is Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getCharanName()
    {
        return $this->hasOne(Charan::className(), ['ID' => 'charan_id']);
    }
}
