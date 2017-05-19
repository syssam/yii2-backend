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
      <h4>John Doe</h4>
      <small>Administrator</small>
    </div>
  </div>
  <ul id="menu">
    <li id="menu-dashboard">
      <a href="http://localhost/demo/admin/index.php?route=common/dashboard&amp;token=mDAYHW2gIJwB5d3ho12ZPLAgEEweYpei"><i class="fa fa-dashboard fw"></i> <span>Dashboard</span></a>
    </li>
    <li id="menu-customer">
      <a class="parent"><i class="fa fa-user fw"></i> <span>Customers</span></a>
      <ul>
        <li><a href="<?= Url::to(['admin/index']); ?>">Admin</a></li>
      </ul>
    </li>
  </ul>
</nav>
