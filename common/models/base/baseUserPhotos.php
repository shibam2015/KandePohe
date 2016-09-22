<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "user_photos".
 *
 * @property integer $iPhoto_ID
 * @property integer $iUser_ID
 * @property string $File_Name
 * @property string $Is_Profile_Photo
 * @property string $dtCreated
 * @property string $dtModified
 */
class baseUserPhotos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'File_Name'], 'required'],
            [['iUser_ID'], 'integer'],
            [['File_Name', 'Is_Profile_Photo'], 'string'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPhoto_ID' => 'I Photo  ID',
            'iUser_ID' => 'I User  ID',
            'File_Name' => 'File  Name',
            'Is_Profile_Photo' => 'Is  Profile  Photo',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
