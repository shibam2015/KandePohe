<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "residency_status".
 *
 * @property integer $ID
 * @property string $Name
 * @property string $created_on
 * @property string $modified_on
 */
class ResidencyStatus extends \common\models\base\baseResidencyStatus
{

    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';

    public static function tableName()
    {
        return 'residency_status';
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
    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['Name', 'created_on', 'modified_on'],
            self::SCENARIO_UPDATE => ['Name', 'modified_on'],
        ];

    }
}
