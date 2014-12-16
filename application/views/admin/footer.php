<?php
  $extend_menu = '';
  if($_SESSION[ci()->config->item('admin_auth_key')]["info"]["roleid"] == 1) {
    $extend_menu = ",{id:'3',text:'管理员',href:'".site_url("admin/admin/index")."'}";
  }
?>
  <script type="text/javascript" src="<?php echo config('base_url').config('common_static').'assets/js/jquery-1.8.1.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo config('base_url').config('common_static').'assets/js/bui-min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo config('base_url').config('common_static').'assets/js/main-min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo config('base_url').config('common_static').'assets/js/config-min.js'; ?>"></script>
  <script>
    BUI.use('common/main',function(){
      var config=[{id:'1',homePage:'4',menu:[{text:'内容管理',items:[{id:'4',text:'文章管理',href:'<?php echo site_url("admin/article/index"); ?>'}]},{text:'系统管理',items:[{id:'2',text:'修改密码',href:'<?php echo site_url("admin/admin/changepwd"); ?>'}<?php echo $extend_menu;?>]}]}];
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>
 </body>
</html>