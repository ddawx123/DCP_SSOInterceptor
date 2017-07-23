<?php



#注册插件



RegisterPlugin("dingstudio_track","ActivePlugin_dingstudio_track");







function ActivePlugin_dingstudio_track() {
    Add_Filter_Plugin('Filter_Plugin_Html_Js_Add', 'dingstudio_track_js_add');
    Add_Filter_Plugin('Filter_Plugin_Admin_Js_Add', 'dingstudio_track_js_add');
}


function dingstudio_track_js_add() {
    global $zbp;
    echo "\r\n" . 'document.writeln("<script src=\'' . $zbp->host . 'zb_users/plugin/dingstudio_track/js/main.js\' type=\'text/javascript\'></script>");';
}


function InstallPlugin_dingstudio_track() {
    global $zbp;
    $zbp->ShowHint('good','ZBP系统接口挂接成功！插件启用完成。');
}



function UninstallPlugin_dingstudio_track() {
    global $zbp;
    $zbp->ShowHint('good','ZBP系统接口挂接取消！插件停用完成。');
}