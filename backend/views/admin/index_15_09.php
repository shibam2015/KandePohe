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

    <p>
        <?= Html::a('Create Admin', ['create'], ['class' => 'btn btn-success']) ?>
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
                        return '<button class="btn btn-green">&nbsp;&nbsp;Active&nbsp;&nbsp;</button>';
                    }
                    else
                    {
                        return '<button class="btn red">Inactive</button>';
                    }
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
