<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

?>

<?php
?>
<div class="panel-heading"><h3><strong>Other conversation with member
            (<?= count($MailListArray) ?>)
        </strong></h3></div>
<div class="panel-body">
    <table class="table table-condensed">
        <tbody>
        <?php
        foreach ($MailListArray as $MKey => $MValue) { ?>
            <tr data-toggle="collapse" data-target="#demo<?= $MKey ?>"
                class="accordion-toggle">
                <td>
                    <button class="btn btn-default btn-xs"><span
                            class="glyphicon glyphicon-eye-open"></span></button>
                </td>
                <td><?= $MValue['Registration_Number'] ?>(<?= $MValue['FullName'] ?>)</td>
                <td>
                    <?= $MValue['Subject'] ?></td>
                <td>On <?= CommonHelper::DateTime($MValue['Date'], 27); ?></td>
            </tr>
            <tr>
                <td colspan="12" class="hiddenRow">
                    <div class="accordian-body collapse" id="demo<?= $MKey ?>">
                        <?= str_replace("#NAME#", $model->fromUserInfo->fullName, $MValue['MailContent']) ?>
                    </div>
                </td>
            </tr>
        <?php }
        ?>
        </tbody>
    </table>
</div>
