<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

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
class UserPhotos extends \common\models\base\baseUserPhotos
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
            'iPhoto_ID' => 'Photo  ID',
            'iUser_ID' => 'User  ID',
            'File_Name' => 'File  Name',
            'Is_Profile_Photo' => 'Is  Profile  Photo',
            'dtCreated' => 'Created',
            'dtModified' => 'Modified',
        ];
    }

    public function findByUserId($iUser_ID)
    {
        return static::findAll(['iUser_ID' => $iUser_ID]);
    }

    public function findByPhotoId($iUser_ID, $P_ID)
    {
        return static::findOne(['iUser_ID' => $iUser_ID, 'iPhoto_ID' => $P_ID]);
    }

    public function updateIsProfilePhoto($iUser_ID)
    {
        return static::updateAll(array('Is_Profile_Photo' => 'NO'), 'iUser_ID="' . $iUser_ID . '"');
    }
}
