<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "site_cms".
 *
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property string $description
 */
class baseSiteCms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_cms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title', 'description'], 'required'],
            [['description'], 'string'],
            [['type', 'title'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }
}
