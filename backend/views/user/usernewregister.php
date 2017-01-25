<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'New Registered User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">User Newly Registered List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                                       aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">

                                    </thead>
                                    <tbody>


                                    <!-- <h1><?= Html::encode($this->title) ?></h1>-->
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
                                            'Mobile',
                                            [
                                                'attribute' => 'status',
                                                #'filter' => [5=>'Approve'],
                                                'filter' => false,
                                                'format' => 'raw',
                                                'value' => function ($model, $key, $index) {
                                                    if ($model->status == 1) {
                                                        return '<button class="btn btn-success">&nbsp;&nbsp;Active&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 2) {
                                                        return '<button class="btn bg-navy btn-flat margin">&nbsp;&nbsp;Inactive&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 3) {
                                                        return '<button class="btn bg-yellow">&nbsp;&nbsp;Pending&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 4) {
                                                        return '<button class="btn bg-red">&nbsp;&nbsp;Disapprove&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 5) {
                                                        return '<button class="btn btn-success">&nbsp;&nbsp;Approve&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 6) {
                                                        return '<button class="btn bg-yellow">&nbsp;&nbsp;Block&nbsp;&nbsp;</button>';
                                                    }
                                                },
                                            ],

                                            #['class' => 'yii\grid\ActionColumn'],
                                            ['class' => 'yii\grid\ActionColumn',
                                                'template' => '{view}',
                                                #'template'=>'{view} {approve}',
                                                'buttons' => [
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
