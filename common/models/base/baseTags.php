<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $ID
 * @property string $Name
 * @property string $created_on
 * @property string $modified_on
 */
class baseTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
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
            'Name' => 'Name',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
