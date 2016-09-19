<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "education_field".
 *
 * @property integer $iEducationFieldID
 * @property string $vEducationFieldName
 * @property string $status
 */
class baseEducationField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'education_field';
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
            'iEducationFieldID' => 'I Education Field ID',
            'vEducationFieldName' => 'V Education Field Name',
            'status' => 'Status',
        ];
    }
}
