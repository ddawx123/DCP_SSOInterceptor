/**
 * SSO_WordPress辅助服务工具
 * @package DingStudio_WordPress_SSO
 * @copyright DingStudio 2016-2017 All Rights Reserved
 */
//Copyright 2017 DingStudio.Tech 小丁工作室版权所有！

function checkSSO(returnUrl) {//Loading DingStudio SSO Api
    console.log("Please wait, we are connecting to remote application interface ...");
    var xhr;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xhr=new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xhr=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr.onreadystatechange=function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var authdata = xhr.responseXML;
            var authcode = authdata.getElementsByTagName("authcode")[0].firstChild.nodeValue;
            //alert(authcode);
            if (authcode != '0') {
                location.href = blog_host_path + "/wp-login.php?action=SSOController&operate=Login&returnUrl=" + encodeURIComponent(window.location.href);
            }
            console.log("Well, the dingstudio ssoapi has been successfully connected.");
        }
    }
    xhr.withCredentials = true;
    xhr.open("POST","https://passport.dingstudio.cn/sso/api?format=xml",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('cors_domain=' + window.location.protocol + '//' + window.location.host);
}

//显示AJAX跨域登录浮层框架 2017.7.16 15:11 Updated
function showSSOLoginForm() {
    swal({
        title: "<small>登录网站通行证</small>",
        animation: "slide-from-bottom",
        showConfirmButton: true,
        confirmButtonText: "关闭",
        text: '<iframe id="ifrmname" src="https://passport.dingstudio.cn/sso/iframelogin.php?mod=caslogin&returnUrl=' + encodeURIComponent(window.location.href) + '&ref=portalindex" height="160" width="360" marginheight="0" marginwidth="0" scrolling="no" frameborder="0"></iframe>',
        html: true
	},function() {
        checkSSO(window.location.href);
    });
    return false;
}

//显示跨域帐户状态同步退出浮层框架
function showLogoutForm() {
    swal({
        title: "是否退出网站通行证",
        text: "亲，您确认要退出网站用户通行证？继续操作后所有关联站点的登录会话也会同步退出，请确保没有正在进行的工作哦~",
        type: "warning",
        animation: "slide-from-bottom",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        confirmButtonText: "确认",
        cancelButtonText: "取消",
        html: false
    },
    function(){
        setTimeout(function(){
            alert("用户帐号通行证已成功退出！");
            location.href = 'https://passport.dingstudio.cn/sso/login.php?action=dologout&url=' + encodeURIComponent(window.location.href);
        }, 2000);
    });
    return false;
}
