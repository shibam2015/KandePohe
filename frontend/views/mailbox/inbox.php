<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\helpers\ArrayHelper;

?>
<div class="main-section">
    <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
    <main>
        <section class="inbox">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-md-2">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"> Mail
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Mail</a></li>
                                <li><a href="#">Contacts</a></li>
                                <li><a href="#">Tasks</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-9 col-md-10">
                        <div class="pull-left">
                            <div class="checkbox mrg-tp-0">
                                <input id="Remember" type="checkbox" name="Remember" value="check1">
                                <label for="Remember" class="control-label">Select All</label>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">All</a></li>
                                    <li><a href="#">None</a></li>
                                    <li><a href="#">Read</a></li>
                                    <li><a href="#">Unread</a></li>
                                    <li><a href="#">Starred</a></li>
                                    <li><a href="#">Unstarred</a></li>
                                </ul>
                                <button type="button" class="btn btn-default" title="Delete">Delete   </button>
                                <button type="button" class="btn btn-default" title="Refresh">     <span
                                        class="glyphicon glyphicon-refresh"></span>   
                                </button>
                            </div>
                        </div>
                        <div class="pull-right"><span class="text-muted">1-50 of 277 </span>

                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default"><span
                                        class="glyphicon glyphicon-chevron-left"></span></button>
                                <button type="button" class="btn btn-default"><span
                                        class="glyphicon glyphicon-chevron-right"></span></button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-sm-3 col-md-2"><a href="#" class="btn btn-danger btn-sm btn-block" role="button">COMPOSE</a>
                        <hr/>
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="#"><span class="badge pull-right">42</span> Inbox </a></li>
                            <li><a href="#">Starred</a></li>
                            <li><a href="#">Important</a></li>
                            <li><a href="#">Sent Mail</a></li>
                            <li><a href="#"><span class="badge pull-right">3</span>Drafts</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-9 col-md-10">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">All</a></li>
                            <li><a href="#tab2" data-toggle="tab">New</a></li>
                            <li><a href="#tab3" data-toggle="tab"> Read &amp; Not Replied</a></li>
                            <li><a href="#tab4" data-toggle="tab">Accepted</a></li>
                            <li><a href="#tab5" data-toggle="tab">Replied</a></li>
                            <li><a href="#tab6" data-toggle="tab">Not Interested</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="thread-control">
                                            <p class="text-muted">13 Apr 2016 <a href="#" data-toggle="modal"
                                                                                 data-target="#del"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="inbox-thread">
                                            <div class="box-inbox pull-left">
                                                <div class="checkbox mrg-tp-0">
                                                    <input id="chk" type="checkbox" name="chk" value="check1">
                                                    <label for="chk" class="control-label"></label>
                                                </div>
                                            </div>
                                            <div class="box-inbox pull-left">
                                                <?= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?>
                                            </div>
                                            <div class="box-inbox3 pull-right">
                                                <p class="name"><strong>Ishita J</strong></p>
                                                <ul class="list-inline pull-left">
                                                    <li>25 Yrs, 5Ft 1in/155 Cms</li>
                                                    <li><strong>Religion:</strong> Hindu, Caste: Maratha</li>
                                                    <li><strong>Location:</strong> Mumbai, Maharashtra, India</li>
                                                    <li><strong>Education:</strong> MBA</li>
                                                    <li><strong>Occupation:</strong> Human Resource Professional</li>
                                                </ul>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <p class="mrg-bt-20"><a class="small-focus" href="#">Phone Number
                                                        Viewed</a> This member is interested in your profile and viewed
                                                    your phone number.</p>
                                                <button class="btn btn-primary" data-target="#sendMail"
                                                        data-toggle="modal">Send Mail
                                                </button>
                                                <a href="more-conversation.html" class="btn btn-info pull-right">+3 more
                                                    conversation</a></div>
                                            <div class="clearfix"></div>
                                            <div></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="thread-control">
                                            <p class="text-muted">13 Apr 2016 <a href="#" data-toggle="modal"
                                                                                 data-target="#del"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="inbox-thread">
                                            <div class="box-inbox pull-left">
                                                <div class="checkbox mrg-tp-0">
                                                    <input id="chk" type="checkbox" name="chk" value="check1">
                                                    <label for="chk" class="control-label"></label>
                                                </div>
                                            </div>
                                            <div
                                                class="box-inbox pull-left"> <?= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?> </div>
                                            <div class="box-inbox3 pull-right">
                                                <p class="name"><strong>Ishita J</strong></p>
                                                <ul class="list-inline pull-left">
                                                    <li>25 Yrs, 5Ft 1in/155 Cms</li>
                                                    <li><strong>Religion:</strong> Hindu, Caste: Maratha</li>
                                                    <li><strong>Location:</strong> Mumbai, Maharashtra, India</li>
                                                    <li><strong>Education:</strong> MBA</li>
                                                    <li><strong>Occupation:</strong> Human Resource Professional</li>
                                                </ul>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <p class="mrg-bt-20"><a class="small-focus" href="#">Phone Number
                                                        Viewed</a> This member is interested in your profile and viewed
                                                    your phone number.</p>
                                                <button class="btn btn-primary" data-target="#sendMail"
                                                        data-toggle="modal">Send Mail
                                                </button>
                                                <a href="more-conversation.html" class="btn btn-info pull-right">+3 more
                                                    conversation</a></div>
                                            <div class="clearfix"></div>
                                            <div></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="thread-control">
                                            <p class="text-muted">13 Apr 2016 <a href="#" data-toggle="modal"
                                                                                 data-target="#del"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="inbox-thread">
                                            <div class="box-inbox pull-left">
                                                <div class="checkbox mrg-tp-0">
                                                    <input id="chk" type="checkbox" name="chk" value="check1">
                                                    <label for="chk" class="control-label"></label>
                                                </div>
                                            </div>
                                            <div
                                                class="box-inbox pull-left"> <?= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?> </div>
                                            <div class="box-inbox3 pull-right">
                                                <p class="name"><strong>Ishita J</strong></p>
                                                <ul class="list-inline pull-left">
                                                    <li>25 Yrs, 5Ft 1in/155 Cms</li>
                                                    <li><strong>Religion:</strong> Hindu, Caste: Maratha</li>
                                                    <li><strong>Location:</strong> Mumbai, Maharashtra, India</li>
                                                    <li><strong>Education:</strong> MBA</li>
                                                    <li><strong>Occupation:</strong> Human Resource Professional</li>
                                                </ul>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <p class="mrg-bt-20"><a class="small-focus" href="#">Phone Number
                                                        Viewed</a> This member is interested in your profile and viewed
                                                    your phone number.</p>
                                                <button class="btn btn-primary" data-target="#sendMail"
                                                        data-toggle="modal">Send Mail
                                                </button>
                                                <a href="more-conversation.html" class="btn btn-info pull-right">+3 more
                                                    conversation</a></div>
                                            <div class="clearfix"></div>
                                            <div></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="thread-control">
                                            <p class="text-muted">13 Apr 2016 <a href="#" data-toggle="modal"
                                                                                 data-target="#del"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="inbox-thread">
                                            <div class="box-inbox pull-left">
                                                <div class="checkbox mrg-tp-0">
                                                    <input id="chk" type="checkbox" name="chk" value="check1">
                                                    <label for="chk" class="control-label"></label>
                                                </div>
                                            </div>
                                            <div
                                                class="box-inbox pull-left"> <?= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?> </div>
                                            <div class="box-inbox3 pull-right">
                                                <p class="name"><strong>Ishita J</strong></p>
                                                <ul class="list-inline pull-left">
                                                    <li>25 Yrs, 5Ft 1in/155 Cms</li>
                                                    <li><strong>Religion:</strong> Hindu, Caste: Maratha</li>
                                                    <li><strong>Location:</strong> Mumbai, Maharashtra, India</li>
                                                    <li><strong>Education:</strong> MBA</li>
                                                    <li><strong>Occupation:</strong> Human Resource Professional</li>
                                                </ul>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <p class="mrg-bt-20"><a class="small-focus" href="#">Phone Number
                                                        Viewed</a> This member is interested in your profile and viewed
                                                    your phone number.</p>
                                                <button class="btn btn-primary" data-target="#sendMail"
                                                        data-toggle="modal">Send Mail
                                                </button>
                                                <a href="more-conversation.html" class="btn btn-info pull-right">+3 more
                                                    conversation</a></div>
                                            <div class="clearfix"></div>
                                            <div></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade in" id="tab2">
                                <div class="list-group">
                                    <div class="list-group-item"><span class="text-center">There are no conversations with this label.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="tab3"> There are no conversations with this label.</div>
                            <div class="tab-pane fade in" id="tab4"> There are no conversations with this label.</div>
                            <div class="tab-pane fade in" id="tab5"> There are no conversations with this label.</div>
                            <div class="tab-pane fade in" id="tab6"> There are no conversations with this label.</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</div>
<!-- remove list -->
<div class="modal fade" id="del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center">Delete conversation</h2>
            </div>
            <!-- Modal Body -->
            <div class="modal-body text-center">
                <p>Are you sure you want to delete this conversation?</p>

                <p>&nbsp;</p>

                <p>
                    <button class="btn btn-primary">Yes</button>
                    <button class="btn btn-primary" data-dismiss="modal">cancel</button>
                </p>
            </div>
        </div>
        <!-- Modal Footer -->
    </div>
</div>
<!-- send mail -->
<div class="modal fade" id="sendMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center">Send Deepika(R175455) a Personalised Message</h2>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9 col-sm-8">
                        <div class="form-group">
                            <label for="msg">Enter your message</label>
                            <textarea class="form-control msg-b" rows="4" id="msg"
                                      placeholder="Type message here..."></textarea>
                        </div>
                        <div class="checkbox mrg-tp-0">
                            <input id="save" type="checkbox" name="Photo" value="check1">
                            <label for="save" class="control-label font-15">Save this as your default message for future
                                communications.</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <?= Html::img('@web/images/profile-pic.jpg', ['width' => '200', 'height' => '200', 'alt' => 'Profile', 'class' => 'img-responsive mrg-tp-20']); ?>

                    </div>
                </div>
                <p>
                    <button class="btn btn-primary">Send message</button>
                    <button class="btn btn-primary" data-dismiss="modal">cancel</button>
                </p>
            </div>
        </div>
        <!-- Modal Footer -->
    </div>
</div>
<script src="<?= Yii::$app->homeUrl ?>js/jquery.js" type="text/javascript"></script>
<script src="<?= Yii::$app->homeUrl ?>js/selectFx.js"></script>
