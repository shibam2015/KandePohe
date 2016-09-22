<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admins';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="admin-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Admin Table List</h3>
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
                                    <p>
                                        <?= Html::a('Create Admin', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                                    </p>
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

                                            //'iAdminId',

                                            #'vFirstName:ntext',
                                            [
                                                'attribute'=>'vFirstName',
                                                //'filter' => ['Active'=>'Active', 'Inactive'=>'Inactive'],
                                                'format'=>'raw',
                                                'value' => function($model, $key, $index)
                                                {

                                                    return ucwords($model->vFirstName);


                                                },
                                            ],
                                            [
                                                'attribute'=>'vLastName',
                                                'format'=>'raw',
                                                'value' => function($model, $key, $index)
                                                {
                                                    return ucwords($model->vLastName);
                                                },
                                            ],
                                            #'vLastName:ntext',
                                            'vEmail:ntext',
                                            //'vPassword:ntext',
                                            #'eStatus',
                                            [
                                                'attribute'=>'eStatus',
                                                'filter' => ['Active'=>'Active', 'Inactive'=>'Inactive'],
                                                'format'=>'raw',
                                                'value' => function($model, $key, $index)
                                                {
                                                    if($model->eStatus == 'Active')
                                                    {
                                                        return '<button class="btn btn-success">&nbsp;&nbsp;Active&nbsp;&nbsp;</button>';
                                                    }
                                                    else
                                                    {
                                                        return '<button class="btn bg-navy">Inactive</button>';
                                                    }
                                                },
                                            ],
                                            ['class' => 'yii\grid\ActionColumn'],
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
