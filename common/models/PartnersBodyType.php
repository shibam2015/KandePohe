<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_body_type".
 *
 * @property integer $iPartners_Body_Type_ID
 * @property integer $iUser_ID
 * @property integer $iBody_Type_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnersBodyType extends \common\models\base\basePartnersBodyType
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_body_type';
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
            [['iUser_ID', 'iBody_Type_ID'], 'required'],
            [['iUser_ID', 'iBody_Type_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Body_Type_ID' => 'I Partners  Body  Type  ID',
            'iUser_ID' => 'I User  ID',
            'iBody_Type_ID' => 'I Body  Type  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
