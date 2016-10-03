<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_education_field".
 *
 * @property integer $iPartners_Education_Field_ID
 * @property integer $iUser_ID
 * @property integer $iEducation_Field_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnersEducationField extends \common\models\base\basePartnersEducationField
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_education_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iEducation_Field_ID'], 'required'],
            [['iUser_ID', 'iEducation_Field_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Education_Field_ID' => 'I Partners  Education  Field  ID',
            'iUser_ID' => 'I User  ID',
            'iEducation_Field_ID' => 'I Education  Field  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
