<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "family_affluence_level".
 *
 * @property integer $ID
 * @property string $Name
 * @property string $created_on
 * @property string $modified_on
 */
class FamilyAffluenceLevel extends \common\models\base\baseCharan
{

    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';

    public static function tableName()
    {
        return 'family_affluence_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'created_on', 'modified_on'], 'required'],
            [['created_on', 'modified_on'], 'safe'],
            [['Name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name' => 'FamilyAffluenceLevel',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['Name', 'created_on', 'modified_on'],
            self::SCENARIO_UPDATE => ['Name', 'modified_on'],
        ];

    }

}
