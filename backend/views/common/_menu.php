<?php
use yii\helpers\Url;

if (Yii::$app->user->isGuest) {
    return;
}?>
<nav id="column-left">
  <div id="profile">
    <div>
      <i class="fa fa-google"></i>
    </div>
    <div>
      <h4><?=ucfirst(Yii::$app->user->identity->username); ?></h4>
      <small>Administrator</small>
    </div>
  </div>
  <ul id="menu">
    <li id="menu-dashboard">
      <a href="http://localhost/demo/admin/index.php?route=common/dashboard&amp;token=mDAYHW2gIJwB5d3ho12ZPLAgEEweYpei"><i class="fa fa-dashboard fw"></i> <span>Dashboard</span></a>
    </li>
    <li id="menu-catalog" class="active open">
      <a class="parent"><i class="fa fa-tags fw"></i> <span>Catalog</span></a>
      <ul>
        <li><a href="<?= Url::to(['manufacturer/index']); ?>">Manufacturers</a></li>
      </ul>
    </li>
    <li id="menu-customer">
      <a class="parent"><i class="fa fa-user fw"></i> <span>Customers</span></a>
      <ul>
        <li><a href="<?= Url::to(['admin/index']); ?>">Admin</a></li>
        <li><a href="<?= Url::to(['banner/index']); ?>">Banner</a></li>
      </ul>
    </li>
  </ul>
</nav>
