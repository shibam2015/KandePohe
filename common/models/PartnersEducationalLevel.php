<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_educational_level".
 *
 * @property integer $iPartners_Educational_Level_ID
 * @property integer $iUser_ID
 * @property integer $iEducation_Level_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnersEducationalLevel extends \common\models\base\basePartnersEducationalLevel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_educational_level';
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
          //  [['iUser_ID', 'iEducation_Level_ID'], 'required'],
          //  [['iUser_ID', 'iEducation_Level_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Educational_Level_ID' => 'I Partners  Educational  Level  ID',
            'iUser_ID' => 'I User  ID',
            'iEducation_Level_ID' => 'Education Level',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public function getEducationLevelName()
    {
        return $this->hasOne(EducationLevel ::className(), ['iEducationLevelID' => 'iEducation_Level_ID']);
    }
}
