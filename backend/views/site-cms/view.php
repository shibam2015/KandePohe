<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\CommonHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SiteCms */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Site Cms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body box-profile">
        <!--<img class="profile-user-img img-responsive img-circle" src="<?= Yii::getAlias('@web') . '/images/' ?>default.png" alt="User profile picture">-->
        <h3 class="profile-username text-center"><?php echo $this->title = ucwords($model->title); ?></h3>
        <!--<p class="text-muted text-center">Email Format</p>-->
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'id',
            #'type',
            'title',
            #'description:ntext',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => (html_entity_decode($model->description)),
            ],

        ],
    ]) ?>
    <!--<div class="row">
        <div class="col-md-12">
            <? /*= $model->description */ ?>
        </div>
    </div>-->
    <div class="row">
        <div class="col-md-6">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-block btn-primary']) ?>
        </div>
        <div class="col-md-6">
            <?= Html::a('Delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-block',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

</div>
