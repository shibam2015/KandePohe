<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$ABC = Yii::$app->urlManager->parseRequest(Yii::$app->request);
$TITLE ='';
$FLAG_ST = 1;
if($ABC[0]=='user/userapprove'){
    $TITLE ='Approved User List';
}else if($ABC[0]=='user/useractive'){
    $TITLE ='Newly Register User List';
}else{
    $TITLE = 'Users';
    $FLAG_ST = 0;
}
$this->title = $TITLE;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">User List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">

                                    </thead>
                                    <tbody>

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
                                                'filter' => [1=>'Active', 2=>'Inactive',3=>'Pending',4=>'Disapprove',5=>'Approve'],
                                                'format'=>'raw',
                                                'value' => function($model, $key, $index)
                                                {
                                                    if($model->status == 1)
                                                    {
                                                        return '<button class="btn btn-success">&nbsp;&nbsp;Actived&nbsp;&nbsp;</button>';
                                                    }
                                                    else if($model->status == 2)
                                                    {
                                                        return '<button class="btn bg-navy btn-flat margin">&nbsp;&nbsp;Inactived&nbsp;&nbsp;</button>';
                                                    }
                                                    else if($model->status == 3)
                                                    {
                                                        return '<button class="btn bg-yellow">&nbsp;&nbsp;Pending&nbsp;&nbsp;</button>';
                                                    }
                                                    else if($model->status == 4)
                                                    {
                                                        return '<button class="btn bg-red">&nbsp;&nbsp;Disapproved&nbsp;&nbsp;</button>';
                                                    }
                                                    else if($model->status == 5)
                                                    {
                                                        return '<button class="btn btn-success">&nbsp;&nbsp;Approved&nbsp;&nbsp;</button>';
                                                    }
                                                    else if($model->status == 6)
                                                    {
                                                        return '<button class="btn bg-yellow">&nbsp;&nbsp;Blocked&nbsp;&nbsp;</button>';
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

                                                'template'=>'{view} {approve} {disapprove} {block}',
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
                                                        return Html::a('<span class="fa  fa-check-circle bg-green"></span>', $url, [
                                                            'title' => Yii::t('yii', 'Approve'),
                                                            'data-confirm' => \Yii::t('yii', 'Are you sure to Approve this user?'),
                                                            'data-method' => 'post',
                                                            'data-pjax' => '0',
                                                        ]);

                                                    },
                                                    'disapprove' => function ($url, $model) {
                                                        return Html::a('<span class="fa   fa-times-circle bg-red" ></span>', $url, [
                                                            'title' => Yii::t('yii', 'Disapprove'),
                                                            'data-confirm' => \Yii::t('yii', 'Are you sure to disapprove this user?'),
                                                            'data-method' => 'post',
                                                            'data-pjax' => '0',
                                                        ]);

                                                    },
                                                    'block' => function ($url, $model) {
                                                        return Html::a('<span class="fa  fa-minus-circle bg-yellow" ></span>', $url, [
                                                            'title' => Yii::t('yii', 'Block'),
                                                            'data-confirm' => \Yii::t('yii', 'Are you sure to Block this user?'),
                                                            'data-method' => 'post',
                                                            'data-pjax' => '0',
                                                        ]);

                                                    }
                                                ]
                                            ],
                                        ],
                                    ]); ?>
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col -->
    </div>
