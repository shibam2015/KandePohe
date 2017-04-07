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
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_description
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
            [['id', 'type', 'title', 'description', 'meta_title', 'meta_keyword', 'meta_description'], 'required'],
            [['id'], 'integer'],
            [['description', 'meta_title', 'meta_keyword', 'meta_description'], 'string'],
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
            'meta_title' => 'Meta Title',
            'meta_keyword' => 'Meta Keyword',
            'meta_description' => 'Meta Description',
        ];
    }
}
