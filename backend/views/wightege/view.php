<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Wightege */

$this->title = $model->iWightege;
$this->params['breadcrumbs'][] = ['label' => 'Wighteges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="wightege-view">-->
<div class="box box-primary">
    <div class="box-body box-profile">
        <h3 class="profile-username text-center"><?php echo $this->title = ucwords($model->vWightegeName); ?></h3>
        <p class="text-muted text-center">Wightege</p>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'iWightege',
            'vWightegeName:ntext',
            'vWightegePercent:ntext',
        ],
    ]) ?>
    <div class="row">
        <div class="col-md-6">
            <?= Html::a('Update', ['update', 'id' => $model->iWightege], ['class' => 'btn btn-block btn-primary']) ?>
        </div>
        <div class="col-md-6">
            <?= Html::a('Delete', ['delete', 'id' => $model->iWightege], ['class' => 'btn btn-danger btn-block',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>

    </div>



    <!-- /.box-body -->
</div>
