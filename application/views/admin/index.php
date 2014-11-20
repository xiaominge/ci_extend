<?php $this->load->view("admin/header");?>

<?php

// echo "<pre>";print_r($_SESSION);exit();

if(isset($_SESSION) && $_SESSION) {
  $username = $_SESSION[$this->config->item('admin_auth_key')]["info"]["name"];
} else {
  $username = '管理员';
}
?>

  <div class="header">
    
      <div class="dl-title">
       <!--<img src="/chinapost/Public/assets/img/top.png">-->
      </div>

    <div class="dl-log">欢迎您，<span class="dl-log-user"><?php echo $username; ?></span><a href="<?php echo site_url('admin/index/logout'); ?>" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
          <li class="nav-item dl-selected"><div class="nav-item-inner"> 后台管理 </div></li>
      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>

<?php $this->load->view("admin/footer");?>