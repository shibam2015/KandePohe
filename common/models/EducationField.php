<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "education_field".
 *
 * @property integer $iEducationFieldID
 * @property string $vEducationFieldName
 * @property string $status
 */
class EducationField extends \common\models\base\baseEducationField
{
    public static function getEducationFieldNames($iEducationFieldID)
    {
        return static::find()->select('vEducationFieldName')->where('iEducationFieldID In (' . $iEducationFieldID . ')')->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vEducationFieldName'], 'required'],
            [['status'], 'string'],
            [['vEducationFieldName'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iEducationFieldID' => 'Education Field ID',
            'vEducationFieldName' => 'Education Field Name',
            'status' => 'Status',
        ];
    }
}
