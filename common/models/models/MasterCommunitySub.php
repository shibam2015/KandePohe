<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_community_sub".
 *
 * @property integer $iSubCommunity_ID
 * @property string $vName
 * @property string $eStatus
 */
class MasterCommunitySub extends \common\models\base\baseMasterCommunitySub
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'master_community_sub';
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vName'], 'required'],
            [['eStatus'], 'string'],
            [['vName'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iSubCommunity_ID' => 'Sub Community ID',
            'vName' => 'Sub Community Name',
            'eStatus' => 'Sub Community Status',
        ];
    }
}
