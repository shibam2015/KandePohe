<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "education_level".
 *
 * @property integer $iEducationLevelID
 * @property string $vEducationLevelName
 * @property string $status
 */
class baseEducationLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'education_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vEducationLevelName'], 'required'],
            [['status'], 'string'],
            [['vEducationLevelName'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iEducationLevelID' => 'I Education Level ID',
            'vEducationLevelName' => 'V Education Level Name',
            'status' => 'Status',
        ];
    }
}
