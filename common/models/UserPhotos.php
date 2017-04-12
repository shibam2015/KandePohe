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
    const PHOTO_APRROVED = 'Approve';
    const PHOTO_DISAPPROVE = 'Disapprove';
    const PHOTO_PENDING = 'Pending';
    public $photo_id;
    public $comment;
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
            [['dtCreated', 'dtModified', 'eStatus'], 'safe'],
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
            'eStatus' => 'Status'
        ];
    }

    public function findByUserId($iUser_ID, $Limit = 0)
    {
        if ($Limit == 0) $Limit = Yii::$app->params['total_files_allowed'];
        return static::find()->where(['iUser_ID' => $iUser_ID])->limit($Limit)->orderBy(['Is_Profile_Photo' => SORT_ASC])->all();
        #return static::find()->where(['iUser_ID' => $iUser_ID])->limit($Limit)->orderBy(['iPhoto_ID' => SORT_DESC])->all();
    }

    public function userPhotoList($iUser_ID, $Limit = 0)
    {
        if ($Limit == 0) $Limit = Yii::$app->params['total_files_allowed'];
        return static::find()->where(['iUser_ID' => $iUser_ID])->andWhere(['eStatus' => self::PHOTO_APRROVED])->limit($Limit)->orderBy(['Is_Profile_Photo' => SORT_ASC])->all();
    }

    public function totalUploadPhotos($iUser_ID)
    {
        return static::find()->where(['iUser_ID' => $iUser_ID])->count();
    }

    public function findByPhotoId($iUser_ID, $P_ID)
    {
        return static::findOne(['iUser_ID' => $iUser_ID, 'iPhoto_ID' => $P_ID]);
    }

    public function updateIsProfilePhoto($iUser_ID)
    {
        return static::updateAll(array('Is_Profile_Photo' => 'NO'), 'iUser_ID="' . $iUser_ID . '"');
    }

    public function findByProfilePhoto($iUser_ID)
    {
        return static::findOne(['iUser_ID' => $iUser_ID, 'Is_Profile_Photo' => 'YES']);
    }
}
