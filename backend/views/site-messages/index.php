<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SiteMessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Site Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-messages-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Site Messages List</h3>
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
                                    <p>
                                        <!-- <? /*= Html::a('Create Site Messages', ['create'], ['class' => 'btn btn-success pull-right']) */ ?> -->
                                    </p>
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

                                            #'id',
                                            'message_action',
                                            #'message_type',
                                            [
                                                'attribute' => 'message_type',
                                                'filter' => ['S' => 'SUCESS', 'E' => 'ERROR', 'I' => 'INFORMATION', 'T' => 'TITLE'],
                                                'format' => 'raw',
                                                'value' => function ($model, $key, $index) {
                                                    if ($model->message_type == 'S') {
                                                        return '<div class="text-center"> <button class="btn btn-success">&nbsp;&nbsp;SUCESS&nbsp;&nbsp;</button></div>';
                                                    } else if ($model->message_type == 'E') {
                                                        return '<div class="text-center"><button class="btn bg-red">ERROR</button></div>';
                                                    } else if ($model->message_type == 'I') {
                                                        return '<div class="text-center"><button class="btn bg-yellow">INFORMATION</button></div>';
                                                    } else {
                                                        return '<div class="text-center"><button class="btn bg-blue">TITLE</button></div>';
                                                    }
                                                },
                                            ],
                                            'message_value:ntext',
                                            'Subject:ntext',

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
