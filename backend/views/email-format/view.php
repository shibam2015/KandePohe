<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\CommonHelper;
use common\components\MailHelper;

/* @var $this yii\web\View */
/* @var $model common\models\EmailFormat */

$this->title = $model->vEmailFormatTitle;
$this->params['breadcrumbs'][] = ['label' => 'Email Formats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$MAIL_HTML = MailHelper::mailFormat($model->tEmailFormatDesc, $model->vEmailFormatTitle);
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
            #'tEmailFormatDesc:ntext',
            /*[
                'attribute' => 'tEmailFormatDesc',
                'format' => 'raw',
                'value' => function ($model, $key, $index) {
                    return strip_tags($model->tEmailFormatDesc);
                },
            ],*/
            /*[
                'attribute' => 'tEmailFormatDesc',
                'format' => 'raw',
                'value' => function ($model, $key, $index) {
                    #return $MailHelper->mailFormat($model->tEmailFormatDesc,$model->vEmailFormatTitle);
                    //return "Sadadd";//MailHelper::mailFormat($model->tEmailFormatDesc,$model->vEmailFormatTitle);
                },
            ],*/
            #'vDescriptionDisplay:ntext',
            #'vTags:ntext',
        ],
    ]) ?>
    <div class="row">
        <div class="col-md-12">
            <?= $MAIL_HTML ?>
        </div>
    </div>

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
