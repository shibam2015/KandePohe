<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
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

                                    <!--<h1><? /*= Html::encode($this->title) */ ?></h1>-->
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
                                                'filter' => false,//[1=>'Active', 2=>'Inactive',3=>'Pending',4=>'Disapprove',5=>'Approve'],
                                                'format' => 'raw',
                                                'value' => function ($model, $key, $index) {
                                                    if ($model->status == 1) {
                                                        return '<button class="btn btn-success">&nbsp;&nbsp;Actived&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 2) {
                                                        return '<button class="btn bg-navy btn-flat margin">&nbsp;&nbsp;Inactived&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 3) {
                                                        return '<button class="btn bg-yellow">&nbsp;&nbsp;Pending&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 4) {
                                                        return '<button class="btn bg-red">&nbsp;&nbsp;Disapproved&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 5) {
                                                        return '<button class="btn btn-success">&nbsp;&nbsp;Approved&nbsp;&nbsp;</button>';
                                                    } else if ($model->status == 6) {
                                                        return '<button class="btn bg-yellow">&nbsp;&nbsp;Blocked&nbsp;&nbsp;</button>';
                                                    }
                                                },
                                            ],
                                            ['class' => 'yii\grid\ActionColumn',

                                                'template' => '{view} {disapprove} {photos} {bio}',
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
                                                    'disapprove' => function ($url, $model) {
                                                        return Html::a('<span class="fa   fa-times-circle bg-red" ></span>', $url, [
                                                            'title' => Yii::t('yii', 'Disapprove'),
                                                            'data-confirm' => \Yii::t('yii', 'Are you sure to disapprove this user?'),
                                                            'data-method' => 'post',
                                                            'data-pjax' => '0',
                                                        ]);

                                                    },
                                                    'photos' => function ($url, $model) {
                                                        return Html::a('<span class="fa  fa-picture-o"></span>', ['profilepic', 'id' => $model->id], ['title' => 'Photo Album']);
                                                    },
                                                    'bio' => function ($url, $model) {
                                                        return Html::a('<span class="fa fa-file-text-o"></span>', ['inownwords', 'id' => $model->id], ['title' => 'Bio']);
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
