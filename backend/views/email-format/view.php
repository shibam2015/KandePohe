<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\CommonHelper;

/* @var $this yii\web\View */
/* @var $model common\models\EmailFormat */

$this->title = $model->vEmailFormatTitle;
$this->params['breadcrumbs'][] = ['label' => 'Email Formats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body box-profile">
        <!--<img class="profile-user-img img-responsive img-circle" src="<?= Yii::getAlias('@web') . '/images/' ?>default.png" alt="User profile picture">-->

        <h3 class="profile-username text-center"><?php echo $this->title = ucwords($model->vEmailFormatTitle); ?></h3>

        <p class="text-muted text-center">Email Format</p>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'iEmailFormatId:email',
            'vEmailFormatTitle:email',
            'vEmailFormatType:email',
            'vEmailFormatSubject:email',
            'tEmailFormatDesc:ntext',

            #'vDescriptionDisplay:ntext',
            #'vTags:ntext',
        ],
    ]) ?>


    <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
    <div class="row">
        <div class="col-md-6">
            <?= Html::a('Update', ['update', 'id' => $model->iEmailFormatId], ['class' => 'btn btn-block btn-primary']) ?>
        </div>
        <div class="col-md-6">
            <?= Html::a('Delete', ['delete', 'id' => $model->iEmailFormatId], ['class' => 'btn btn-danger btn-block',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>

    </div>


    <!-- /.box-body -->
</div>
