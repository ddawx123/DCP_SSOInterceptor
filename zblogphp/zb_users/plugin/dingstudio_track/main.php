<?php



require '../../../zb_system/function/c_system_base.php';



require '../../../zb_system/function/c_system_admin.php';



$zbp->Load();



$action='root';



if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}



if (!$zbp->CheckPlugin('dingstudio_track')) {$zbp->ShowError(48);die();}







$blogtitle='小丁工作室|访问追踪器';



require $blogpath . 'zb_system/admin/admin_header.php';



require $blogpath . 'zb_system/admin/admin_top.php';



?>



<div id="divMain">



  <div class="divHeader"><?php echo $blogtitle;?></div>



  <div class="SubMenu">


  </div>



  <div id="divMain2">
  插件运行正常，已成功挂接c_html_js_add、c_admin_js_add接口。
  <hr>
  <a href="<?php echo $zbp->host.'zb_system/cmd.php?act=PluginDis&name=dingstudio_track&token='.$zbp->GetToken(); ?>" target="_self">点击此处</a>关闭本插件

<!--代码-->



  </div>



</div>







<?php



require $blogpath . 'zb_system/admin/admin_footer.php';



RunTime();



?>