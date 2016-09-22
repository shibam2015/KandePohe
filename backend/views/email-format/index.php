<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\CommonHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EmailFormatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Formats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-format-index">
    <div class="blood-group-index">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Email Format List</h3>
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
                                            <?= Html::a('Create Email Format', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                                        </p>
                                        <?= GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],

                                                #'iEmailFormatId:email',
                                                'vEmailFormatTitle:email',
                                                'vEmailFormatType:email',
                                                'vEmailFormatSubject:email',
                                                #'tEmailFormatDesc:ntext',
                                                [
                                                    'attribute' => 'tEmailFormatDesc',
                                                    'format' => 'raw',
                                                    'value' => function ($model, $key, $index) {
                                                        $commonhelper = new CommonHelper();
                                                        return $commonhelper->truncate(strip_tags($model->tEmailFormatDesc), 500);
                                                    },
                                                ],
                                                #'vDescriptionDisplay:ntext',
                                                #'vTags:ntext',

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
