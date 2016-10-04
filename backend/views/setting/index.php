<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SMS Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">SMS Setting List</h3>
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
                                        <?= Html::a('Create SMS Setting', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                                    </p>
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

                                            #'id',
                                            'SettingName:ntext',
                                            'UseFor:ntext',
                                            'SettingValue:ntext',
                                            #'eStatus',
                                            [
                                                'attribute' => 'eStatus',
                                                'filter' => ['Active' => 'Active', 'Inactive' => 'Inactive'],
                                                'format' => 'raw',
                                                'value' => function ($model, $key, $index) {
                                                    if ($model->eStatus == 'Active') {
                                                        return '<button class="btn btn-success">&nbsp;&nbsp;Active&nbsp;&nbsp;</button>';
                                                    } else {
                                                        return '<button class="btn bg-navy">Inactive</button>';
                                                    }
                                                },
                                            ],
                                            // 'ConfigType',
                                            // 'ElemetType',

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
