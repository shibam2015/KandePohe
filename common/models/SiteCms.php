<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_cms".
 *
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property string $description
 */
class SiteCms extends \common\models\base\baseSiteCms
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


    /*public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['type', 'title', 'description'],
            self::SCENARIO_UPDATE => ['title', 'description'],
        ];

    }*/
}
