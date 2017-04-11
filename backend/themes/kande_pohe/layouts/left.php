<?php
$ADMIN_NAME = ucwords(strtolower(Yii::$app->user->identity->vFirstName. ' ' .Yii::$app->user->identity->vLastName));
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->

        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <?php
                if (!Yii::$app->user->isGuest) {
                ?>
                <p><?=$ADMIN_NAME?></p>
                <?php }else{ ?>
                <p>Guest</p>
                <?php }?>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->
        <?php
        //if (!Yii::$app->user->isGuest) {
            ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Main Menu', 'options' => ['class' => 'header']],
                    //['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    //['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
					['label' => 'admin', 'icon' => 'fa fa-user-secret', 'url' => ['/admin'], 'visible' => !Yii::$app->user->isGuest],
                    #['label' => 'Community', 'icon' => 'fa fa-user-secret', 'url' => ['/master-community'], 'visible' => !Yii::$app->user->isGuest],

                    ['label' => 'Login', 'icon' => 'fa fa-sign-in', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'User Manage',
                        'icon' => 'fa fa-users',
                        'url' => '#',
                        'items' => [
                            ['label' => 'User List (All)', 'icon' => 'fa fa-list', 'url' => ['/user/index'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'User List (Approved)', 'icon' => 'fa  fa-check-circle', 'url' => ['/user/userapprove'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'User List (In Pending Approval)', 'icon' => 'fa fa-list-alt', 'url' => ['/user/in-approval'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'User List (Newly Registered)', 'icon' => 'fa fa-list-alt', 'url' => ['/user/new-registered'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'User List (In Bio)', 'icon' => 'fa fa-file-code-o', 'url' => ['/user/user-in-own-words'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'User List (Photo Album)', 'icon' => 'fa fa-file-code-o', 'url' => ['/user/user-profile-pic'], 'visible' => !Yii::$app->user->isGuest],

                            //['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            /*[
                                'label' => 'Manage',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Active Profiles', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    ['label' => 'Newly Registered User', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    ['label' => 'Recently Edited Photos', 'icon' => 'fa fa-circle-o', 'url' => '#',],

                                ],
                            ],*/
                        ], 'visible' => !Yii::$app->user->isGuest
                    ],
                    [
                        'label' => 'Site Manage One',
                        'icon' => 'fa fa-cog',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Wightege', 'icon' => 'fa fa-hourglass-1', 'url' => ['/wightege'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Community', 'icon' => 'fa fa-bookmark', 'url' => ['/community'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Sub-Community', 'icon' => 'fa fa-bookmark-o', 'url' => ['/sub-community'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Diet', 'icon' => 'fa fa-cutlery', 'url' => ['/diet'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'District', 'icon' => 'fa fa-compass', 'url' => ['/district'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Gotra', 'icon' => 'fa  fa-fire', 'url' => ['/gotra'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Marital-Status', 'icon' => 'fa  fa-heart', 'url' => ['/marital-status'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Height', 'icon' => 'fa  fa-ellipsis-v', 'url' => ['/height'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Taluka', 'icon' => 'fa fa-map-signs', 'url' => ['/taluka'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Father-Mother Status', 'icon' => 'fa fa-venus-double', 'url' => ['/fm-status'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Education Name', 'icon' => 'fa fa-venus-double', 'url' => ['/education-field'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Education Level', 'icon' => 'fa fa-venus-double', 'url' => ['/education-level'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Religion', 'icon' => 'fa  fa-university', 'url' => ['/religion'], 'visible' => !Yii::$app->user->isGuest],

                        ], 'visible' => !Yii::$app->user->isGuest
                    ],
                    [
                        'label' => 'Site Manage Two',
                        'icon' => 'fa fa-cog',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Blood Group', 'icon' => 'fa  fa-medkit', 'url' => ['/blood-group'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Body Type', 'icon' => 'fa fa-yelp', 'url' => ['/body-type'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Charan', 'icon' => 'fa  fa-star', 'url' => ['/charan'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Cultural Background', 'icon' => 'fa  fa-star', 'url' => ['/cultural-background'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Family Affluence Level', 'icon' => 'fa  fa-star', 'url' => ['/family-affluence-level'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Family Wealth Details', 'icon' => 'fa  fa-star', 'url' => ['/family-wealth-details'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Favourite Cousines', 'icon' => 'fa  fa-star', 'url' => ['/favourite-cousines'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Favourite Music', 'icon' => 'fa  fa-star', 'url' => ['/favourite-music'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Favourite Reads', 'icon' => 'fa  fa-star', 'url' => ['/favourite-reads'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Gan', 'icon' => 'fa  fa-star', 'url' => ['/gan'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Hobbies', 'icon' => 'fa  fa-star', 'url' => ['/hobbies'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Interests', 'icon' => 'fa  fa-star', 'url' => ['/interests'], 'visible' => !Yii::$app->user->isGuest],
                            // ['label' => 'Interest Statuses', 'icon' => 'fa  fa-star', 'url' => ['/interest-statuses'], 'visible' => !Yii::$app->user->isGuest],

                            ['label' => 'Mother Tongue', 'icon' => 'fa fa-hourglass-1', 'url' => ['/mother-tongue'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Nadi', 'icon' => 'fa fa-hourglass-1', 'url' => ['/nadi'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Nakshtra', 'icon' => 'fa fa-hourglass-1', 'url' => ['/nakshtra'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Membership Type', 'icon' => 'fa fa-hourglass-1', 'url' => ['/membership-type'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Preferred Dress Style', 'icon' => 'fa fa-hourglass-1', 'url' => ['/preferred-dress-style'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Preferred Movies', 'icon' => 'fa fa-hourglass-1', 'url' => ['/preferred-movies'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Property Details', 'icon' => 'fa fa-hourglass-1', 'url' => ['/property-details'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Raashi', 'icon' => 'fa fa-hourglass-1', 'url' => ['/raashi'], 'visible' => !Yii::$app->user->isGuest],
                            # ['label' => 'Residency Status', 'icon' => 'fa fa-hourglass-1', 'url' => ['/residency-status'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Skin Tone', 'icon' => 'fa fa-hourglass-1', 'url' => ['/skin-tone'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Sports Fitness Activities', 'icon' => 'fa fa-hourglass-1', 'url' => ['/sports-fitn-activities'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Tags', 'icon' => 'fa fa-hourglass-1', 'url' => ['/tags'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Working With', 'icon' => 'fa fa-hourglass-1', 'url' => ['/working-with'], 'visible' => !Yii::$app->user->isGuest],



                        ], 'visible' => !Yii::$app->user->isGuest
                    ],
                    [
                        'label' => 'CMS',
                        'icon' => 'fa fa-folder',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Email Template', 'icon' => 'fa fa-envelope', 'url' => ['/email-format'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'SMS Template', 'icon' => 'fa fa-envelope', 'url' => ['/sms-format'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Site Message', 'icon' => 'fa fa-envelope', 'url' => ['/site-messages'], 'visible' => !Yii::$app->user->isGuest],
                            //  ['label' => 'SMS Setting', 'icon' => 'fa-mobile-phone', 'url' => ['/setting'], 'visible' => !Yii::$app->user->isGuest],

                        ], 'visible' => !Yii::$app->user->isGuest
                    ],
                    ['label' => 'Site CMS', 'icon' => 'fa fa-cog', 'url' => ['/site-cms'], 'visible' => !Yii::$app->user->isGuest],

                    /*['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],*/
                ],
            ]
        ) ?>
<?php //}?>
    </section>

</aside>

