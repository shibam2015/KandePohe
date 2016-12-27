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
                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                                        data-target="#photo">Photo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>


<div class="modal fade photo-kp-crop1 profilecropmodal" id="photo" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog"><!--modal-lg -->
        <p class="text-center mrg-bt-10">
            <img src="<?= \common\components\CommonHelper::getLogo() ?>" width="157" height="61" alt="logo"></p>

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center" id="model_heading"> Set Profile Photo</h2>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="choose-photo">
                    <div class="text-center " id="crop_loader">
                        <i class="fa fa-spinner fa-spin pink"></i> Loading...
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="changePic" class="" style="">
                                <form id="cropimage" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value=""/>
                                    <input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value=""/>
                                    <input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis"/>
                                    <input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis"/>
                                    <input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value=""/>
                                    <input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value=""/>
                                    <input type="hidden" name="action" value="" id="action"/>
                                    <input type="hidden" name="image_name" value="" id="image_name"/>
                                    <input type="hidden" name="image_id" value="" id="image_id"/>

                                    <div id='preview-avatar-profile' class="photo-kp-crop">
                                        <!--<img class="img-responsive preview" id='photov' width="" alt="">-->
                                        <img
                                            src="http://localhost/KandePohe/uploads/users/2/profile/_profile_30071_5850039d97986.jpg?1482826224"
                                            id="croptarget">

                                        <!--<div id="preview-cont">
                                            <img
                                                src="http://upload.wikimedia.org/wikipedia/commons/e/eb/Ash_Tree_-_geograph.org.uk_-_590710.jpg"
                                                id="preview">
                                        </div>-->
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer -->
                </div>
            </div>
            <div class="modal-footer crop_save" style="display: none;">
                <div class="row">
                    <div class="col-md-4 col-sm-10 col-sm-offset-1">
                        <button type="button" class="btn btn-primary mrg-tp-10 col-xs-12" data-dismiss="modal">Back
                        </button>
                    </div>
                    <div class="col-md-4  col-sm-10 col-sm-offset-1 ">
                        <button type="button" id="btn-crop"
                                class="btn btn-primary mrg-tp-10 col-xs-12 crop-save-btn"
                                disabled>Crop & Save
                        </button>
                    </div>
                </div>

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
x1 : 0, y1 : 0, x2 : 150, y2: 150,
minWidth: 100, minHeight: 100,
            aspectRatio: '1:1',
            handles: true,
            show : true,
            fadeSpeed: 200,
            /*x1 : 0, y1 : 0, x2 : 150, y2: 150,
                                handles: true,
                                fadeSpeed: 200,
                                show : true,
                                maxWidth: 250, maxHeight: 250,
                                minWidth: 200, minHeight: 200,
                                aspectRatio: '1:1',*/
            onSelectChange: preview
        });
    });
");
?>



