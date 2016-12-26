<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SmsFormatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sms Formats';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="master-community-sub-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Sms Format List</h3>
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
                                        <?= Html::a('Create Sms Format', ['create'], ['class' => 'btn btn-success pull-right']) ?>

                                    </p>
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

                                            //'iSmsFormatId',
                                            'vSmsFormatType',
                                            'vSmsInformation',
                                            'vSmsMessage:ntext',
                                            'vComment:ntext',

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

