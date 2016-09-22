<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\CommonHelper;



/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users Own Word List' ;
$this->params['breadcrumbs'][] = $this->title;
//$commonhelper = new CommonHelper();

?>
<div class="user-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">User List(In Own Word)</h3>
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

            'First_Name',
            'Last_Name',
            'email:email',
            [
                'attribute'=>'tYourSelf',
                'format'=>'raw',
                'value' => function($model, $key, $index)
                {
                    $commonhelper = new CommonHelper();
                    return $commonhelper->truncate($model->tYourSelf,25);
                },
            ],
            [
                'attribute'=>'eStatusInOwnWord',
                #'filter' => [5=>'Approve'],
                'filter'=>false,
                'format'=>'raw',
                'value' => function($model, $key, $index)
                {
                    if($model->eStatusInOwnWord == 'Approve')
                    {
                        return '<button class="btn btn-success">&nbsp;&nbsp;Approve&nbsp;&nbsp;</button>';
                    }
                    else if($model->eStatusInOwnWord == 'Disapprove')
                    {
                        return '<button class="btn bg-red">&nbsp;&nbsp;Disapprove&nbsp;&nbsp;</button>';
                    }else{
                        return '<button class="btn bg-yellow btn-flat margin">&nbsp;&nbsp;Pending&nbsp;&nbsp;</button>';
                    }

                },
            ],

            #['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',

                'template'=>'{inownwords}',
                'buttons'=>[

                    'inownwords' => function ($url, $model) {
                        return Html::a('<span class="fa fa-eye"></span>', $url, [
                            'title' => Yii::t('app', 'View'),
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
