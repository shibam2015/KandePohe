<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            #'id',
           # 'auth_key',
           # 'password_hash',
           # 'password_reset_token',
            'First_Name',
            'Last_Name',
            'email:email',
             'Mobile',
            # 'status',
            [
                'attribute'=>'status',
                'filter' => false,//[1=>'Active', 2=>'Inactive',3=>'Pending',4=>'Disapprove',5=>'Approve'],
                'format'=>'raw',
                'value' => function($model, $key, $index)
                {
                    if($model->status == 1)
                    {
                        return '<button class="btn btn-success">&nbsp;&nbsp;Active&nbsp;&nbsp;</button>';
                    }
                    else if($model->status == 2)
                    {
                        return '<button class="btn bg-navy btn-flat margin">&nbsp;&nbsp;Inactive&nbsp;&nbsp;</button>';
                    }
                    else if($model->status == 3)
                    {
                        return '<button class="btn bg-yellow">&nbsp;&nbsp;Pending&nbsp;&nbsp;</button>';
                    }
                    else if($model->status == 4)
                    {
                        return '<button class="btn bg-red">&nbsp;&nbsp;Disapprove&nbsp;&nbsp;</button>';
                    }
                    else if($model->status == 5)
                    {
                        return '<button class="btn btn-success">&nbsp;&nbsp;Approve&nbsp;&nbsp;</button>';
                    }
                    else if($model->status == 6)
                    {
                        return '<button class="btn bg-yellow">&nbsp;&nbsp;Block&nbsp;&nbsp;</button>';
                    }
                },
            ],

            // 'created_at',
            // 'updated_at',
            // 'Registration_Number',
            // 'Mobile',
            // 'Profile_created_for',

            // 'Gender',
            // 'DOB',
            // 'Time_of_Birth',
            // 'Age',
            // 'Birth_Place',
            // 'Marital_Status',
            // 'iReligion_ID',
            // 'eFirstVerificationMailStatus',
            // 'iEducationLevelID',
            // 'iEducationFieldID',
            // 'iWorkingWithID',
            // 'iWorkingAsID',
            // 'iAnnualIncomeID',
            // 'iCommunity_ID',
            // 'toc',
            // 'county_code',
            // 'iSubCommunity_ID',
            // 'iDistrictID',
            // 'iGotraID',
            // 'iMaritalStatusID',
            // 'iTalukaID',
            // 'iCountryId',
            // 'iStateId',
            // 'iCityId',
            // 'noc',
            // 'vAreaName:ntext',
            // 'cnb',
            // 'iHeightID',
            // 'vSkinTone:ntext',
            // 'vBodyType:ntext',
            // 'vSmoke:ntext',
            // 'vDrink:ntext',
            // 'vSpectaclesLens:ntext',
            // 'vDiet:ntext',
            // 'tYourSelf:ntext',
            // 'vDisability:ntext',
            // 'propic:ntext',
            // 'pin_email_vaerification:ntext',
            // 'iFatherStatusID',
            // 'iMotherStatusID',
            // 'iFatherWorkingAsID',
            // 'iMotherWorkingAsID',
            // 'nob',
            // 'nos',
            // 'eSameAddress',
            // 'iCountryCAId',
            // 'iStateCAId',
            // 'iDistrictCAID',
            // 'iTalukaCAID',
            // 'vAreaNameCA:ntext',
            // 'iCityCAId',
            // 'vNativePlaceCA:ntext',
            // 'vParentsResiding:ntext',
            // 'vFamilyAffluenceLevel:ntext',
            // 'vFamilyType:ntext',
            // 'vFamilyProperty:ntext',
            // 'vDetailRelative:ntext',
            // 'completed_step',
            // 'eEmailVerifiedStatus:email',
            // 'ePhoneVerifiedStatus',

            #['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',

                'template'=>'{view} {approve}',
                'buttons'=>[
                    'edit' => function ($model, $key, $index, $instance) {
                        $urlConfig = [];
                        foreach ($model->primaryKey() as $pk) {
                            $urlConfig[$pk] = $model->$pk;
                            $urlConfig['type'] = $model->type;
                        }

                        $url = Url::toRoute(array_merge(['modify'], $urlConfig));
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => \Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'approve' => function ($url, $model) {
                        return Html::a('<span class="fa  fa-check-circle"></span>', $url, [
                            'title' => Yii::t('yii', 'Approve'),
                            'data-confirm' => \Yii::t('yii', 'Are you sure to Approve this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);

                    }
                ]
            ],
        ],
    ]); ?>
</div>
