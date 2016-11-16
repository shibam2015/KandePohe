<?php
use common\components\CommonHelper;

?>
<div class="modal fade" id="accept_decline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                </button>
                <h4 class="text-center main_title_popup"> Information </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form>
                    <div class="text-center">
                        <!--<p class="mrg-bt-10 font-15"><span class="text-success"><strong>&#10003;</strong></span> Your interest has been sent successfully to</p>-->
                        <div class="fb-profile-text mrg-bt-30 text-dark">
                            <h1 class="to_name"></h1>(<span class="sub-text mrg-tp-10 to_rg_number"></span>)
                        </div>
                        <h6 class="mrg-bt-30 font-15 text-dark"><strong class="main_msg_popup"></strong></h6>

                        <div class="checkbox mrg-tp-0 profile-control">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <button type="button" class="btn active pull-right a_b_d " data-id=""
                                            data-parentid="" data-type=""> Yes
                                    </button>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 ">
                                    <button type="button" class="btn pull-left" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <!-- Modal Footer -->
        </div>
    </div>
</div>
<script type="text/javascript">
    var AcceptInterest = "<?=Yii::$app->params['acceptInterest']?>";
    var DeclineInterest = "<?=Yii::$app->params['declineInterest']?>";
    var CancelInterest = "<?=Yii::$app->params['cancelInterest']?>";
</script>
