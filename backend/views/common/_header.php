<?php
use yii\helpers\Url;

?>
<header id="header" class="navbar navbar-static-top">
<?php
if (!Yii::$app->user->isGuest) {
    ?>
    <div class="navbar-header">
      <a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
      <a href="#" class="navbar-brand"><div style="height:23px"> </div><!--<img src="#" alt="Brands" title="Brands">--></a></div>
    <ul class="nav pull-right">
      <li><a href="<?=Url::to(['common/logout'])?>"><span class="hidden-xs hidden-sm hidden-md">Logout</span> <i class="fa fa-sign-out fa-lg"></i></a></li>
    </ul>
<?php

} ?>
</header>
