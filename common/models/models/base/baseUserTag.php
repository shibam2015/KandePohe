<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "user_tag".
 *
 * @property integer $id
 * @property integer $tag_id
 * @property integer $iUser_Id
 */
class baseUserTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'iUser_Id'], 'required'],
            [['tag_id', 'iUser_Id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'iUser_Id' => 'I User  ID',
        ];
    }
}
