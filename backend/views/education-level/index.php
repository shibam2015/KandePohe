<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EducationLevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Education Levels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-level-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Education Level List</h3>
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

                                    <!--<h1><?= Html::encode($this->title) ?></h1>-->
                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                                    <p>
                                        <?= Html::a('Create Education Level', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                                    </p>
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

                                            #'iEducationLevelID',
                                            'vEducationLevelName',
                                            'status',

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

