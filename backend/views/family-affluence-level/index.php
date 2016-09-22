<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BloodGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Family Affluence Level';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blood-group-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Family Affluence Level List</h3>
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
                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                                    <p>
                                        <?= Html::a('Create Family Affluence Level', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                                    </p>
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

                                            #'ID',
                                            'Name',
                                            #'created_on',
                                            #'modified_on',

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

