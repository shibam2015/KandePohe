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

    public static function findByUserId($UserID)
    {

        return static::findOne(['iUser_ID' => $UserID]);
    }

    public static function findAllByUserId($UserID)
    {

        return static::findAll(['iUser_ID' => $UserID]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['iUser_ID', 'iEducation_Field_ID'], 'required'],
            //[['iUser_ID', 'iEducation_Field_ID'], 'integer'],
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
            'iEducation_Field_ID' => 'Education Field',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public function getEducationFieldName()
    {
        return $this->hasOne(EducationField ::className(), ['iEducationFieldID' => 'iEducation_Field_ID']);
    }
}
