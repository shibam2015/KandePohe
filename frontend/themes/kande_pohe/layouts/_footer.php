<?php use yii\helpers\Html; ?>
<footer>
  <div class="mega-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-4 txt-justify">
          <!--<h5>Explore Us</h5>-->
          <strong>Kande-Pohe.com</strong> is Marathi matrimony, handcrafted especially for all you Marathi breed,
          existing anywhere on the planet earth or on the Mars for that matter, with a sole purpose of helping you find
          your
          life partner.
          <br><br>Register today for FREE and experience an entire new concept of arranged marriages.

          <!--<ul class="list-unstyled fbox">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Advanced Search</a></li>
            <li><a href="#">Success Stories</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>-->
        </div>
        <div class="col-md-3 col-sm-6 col-md-offset-1">
          <h5>Explore Us</h5>
          <ul class="list-unstyled fbox">
            <li><?= html::a('About Kande-Pohe Marathi Matrimony', ['site/about-us']) ?></li>
            <li><?= html::a('Contact Us', ['site/contact-us']) ?></li>
            <li><?= html::a('Terms of Use / Privacy Policy', ['site/terms-of-use']) ?></li>
            <li><?= html::a('Help / Feedback', ['site/help-feedback']) ?></li>
          </ul>
        </div>
        <div class="col-md-2 col-sm-6">
          <div class="fbox">
            <h5>Customer Service </h5>
            <ul class="list-unstyled fbox">
              <li><a href="javascript:void(0)">(10.00 AM – 07.00 PM)</a></li>
              <li><a href="javascript:void(0)">+91-7387986545</a></li>
            </ul>

          </div>
        </div>
        <div class="col-md-2 col-sm-6">
          <h5>Stay Connected</h5>
          <ul class="list-inline fbox social-icons">
            <li><a href="<?= Yii::$app->params['footerYoutubeURL'] ?>" target="_blank"><i
                    class="fa fa-youtube-square"></i></a></li>
            <li><a href="<?= Yii::$app->params['footerGooglePlusURL'] ?>" target="_blank"><i
                    class="fa fa-google-plus-square"></i></a></li>
            <li><a href="<?= Yii::$app->params['footerTwitterURL'] ?>" target="_blank"><i
                    class="fa fa-twitter-square"></i></a></li>
            <li><a href="<?= Yii::$app->params['footerFacebookURL'] ?>" target="_blank"><i
                    class="fa fa-facebook-square"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="legal">
    <p>&copy; <?= date('Y') ?> Kande Pohe.com. All Rights Reserved.</p>
  </div>
</footer>
