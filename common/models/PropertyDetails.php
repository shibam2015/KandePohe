<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_details".
 *
 * @property integer $ID
 * @property string $Name
 * @property string $created_on
 * @property string $modified_on
 */
class PropertyDetails extends \common\models\base\basePropertyDetails
{

    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';

    public static function tableName()
    {
        return 'property_details';
    }

    public static function getPropertyDetails($InterestString)
    {
        return static::find()->select('Name')->where('ID In (' . $InterestString . ')')->all();
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
            'Name' => 'Property Details',
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
