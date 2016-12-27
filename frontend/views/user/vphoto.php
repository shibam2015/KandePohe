<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\helpers\ArrayHelper;

?>
<div class="" xmlns="http://www.w3.org/1999/html">
    <?php if (Yii::$app->user->identity->eEmailVerifiedStatus == 'Yes' && Yii::$app->user->identity->ePhoneVerifiedStatus == 'Yes') { ?>
        <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
    <?php } else { ?>
        <?php echo $this->render('/layouts/parts/_headerregister.php'); ?>
    <?php } ?>
    <main>
        <div class="main-section">
            <div class="col-md-9 col-sm-12">
                <div class=" right-column" style="margin-left: 73px;">
                </div>
            </div>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="white-section">
                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                                        data-target="#myModal">Open Modal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
                <img src="http://upload.wikimedia.org/wikipedia/commons/e/eb/Ash_Tree_-_geograph.org.uk_-_590710.jpg"
                     id="croptarget">

                <div id="preview-cont">
                    <img
                        src="http://upload.wikimedia.org/wikipedia/commons/e/eb/Ash_Tree_-_geograph.org.uk_-_590710.jpg"
                        id="preview">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<style>
    #container {
        background-color: #ccc;
        width: 500px;
        height: 300px;
        margin-left: 20%;
    }

    #croptarget {
        max-width: 100%;
        max-height: 100%;
    }

    #preview-cont {
        width: 150px;
        height: 150px;
        overflow: hidden;
        border: 1px solid #000;
        float: right;
    }

</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

<?php $this->registerJsFile("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js", ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_END]); ?>
<?php $this->registerJsFile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js", ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_END]); ?>
<link rel="stylesheet" href="http://odyniec.net/projects/imgareaselect/css/imgareaselect-animated.css" type="text/css"/>

<?php $this->registerJsFile("http://odyniec.net/projects/imgareaselect/jquery.imgareaselect.pack.js", ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_END]); ?>

<?php
$this->registerJs("
    $(document).ready(function() {
        function preview(img, selection) {
            if (!selection.width || !selection.height)
                return;
            var scaleX = 150 / selection.width;
            var scaleY = 150 / selection.height;

            $('#preview').css({
                width: Math.round(scaleX * $('#croptarget').width()) + 'px',
                height: Math.round(scaleY * $('#croptarget').height()) + 'px',
                marginLeft: -Math.round(scaleX * selection.x1),
                marginTop: -Math.round(scaleY * selection.y1)
            });
        }

        //dynamic aspect ratio
        var daspectratio = $('#croptarget').height() / $('#croptarget').width();
        var paspectratio = $('#preview-cont').height() / $('#preview-cont').width();
        var dyap = daspectratio + ':' + paspectratio;

        $('#croptarget').imgAreaSelect({

            aspectRatio: '1:1',
            handles: true,
            fadeSpeed: 200,
            onSelectChange: preview
        });
    });
");
?>



