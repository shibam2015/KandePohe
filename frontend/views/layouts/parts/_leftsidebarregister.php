<?php
$BasicInfo = \common\models\User::weightedCheck(2);
$EducationInfo = \common\models\User::weightedCheck(3);
$LifeStyleInfo = \common\models\User::weightedCheck(4);
$FamilyInfo = \common\models\User::weightedCheck(5);
$AboutYourSelfInfo = \common\models\User::weightedCheck(6);

#echo "==".$CurrentStep;exit;
?>
<div class="col-md-3  col-sm-12">
  <div class="sidebar-nav">
    <div class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <span class="visible-xs navbar-brand">Sidebar menu</span> </div>
      <div class="navbar-collapse collapse sidebar-navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="<?= ($CurrentStep == 2) ? 'active' : '' ?> <?= ($BasicInfo) ? 'step_done' : '' ?>">
            <a href="javascript:void()">
              Basic Details
            </a>
          </li>
          <li class="<?= ($CurrentStep == 3) ? 'active' : '' ?> <?= ($EducationInfo) ? 'step_done' : '' ?>">
            <a href="javascript:void()">Education &amp; Occupation</a>
          </li>
          <li class="<?= ($CurrentStep == 4) ? 'active' : '' ?> <?= ($LifeStyleInfo) ? 'step_done' : '' ?>">
            <a href="javascript:void()">Lifestyle &amp; Appearance</a>
          </li>
          <li class="<?= ($CurrentStep == 5) ? 'active' : '' ?> <?= ($FamilyInfo) ? 'step_done' : '' ?>">
            <a href="javascript:void()">Family</a>
          </li>
          <li class="<?= ($CurrentStep == 6) ? 'active' : '' ?> <?= ($AboutYourSelfInfo) ? 'step_done' : '' ?>">
            <a href="javascript:void()">About Yourself</a>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </div>
</div>