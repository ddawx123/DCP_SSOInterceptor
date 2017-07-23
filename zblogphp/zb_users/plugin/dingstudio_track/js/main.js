//JavaScript Document
//Charset UTF-8
/**
 * 用户访问行为控制器
 * @copyright DingStudio 2017 All Rights Reserved
 */

console.log('DingStudio JS Application Loaded Successfully ...');//Output JS Load Message

$(document).ready(function(){
    checkSSO();//启动SSO检查
});

//检查SSO状态
function checkSSO() {
    var xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var authdata = xhr.responseXML;
            var authcode = authdata.getElementsByTagName("authcode")[0].firstChild.nodeValue;
            if (authcode == '1') {
                syncSSOLoginStatus();//同步登录
            }
            else {
                syncSSOLogoutStatus();//同步登出
            }
        }
    }
    xhr.withCredentials = true;
    xhr.open("POST", "https://passport.dingstudio.cn/sso/api?format=xml", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send('cors_domain=' + window.location.protocol + '//' + window.location.host);
}

//同步登录
function syncSSOLoginStatus() {
    var xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = eval("("+xhr.responseText+")");
            var login_status = data.code;
            if (login_status == '401') {
                location.href = bloghost + "/zb_system/cmd.php?act=ssocallback&callback=homepage";
            }
        }
    }
    xhr.withCredentials = true;
    xhr.open("POST", bloghost + "/zb_users/plugin/dingstudio_track/login_status_query.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send('cors_domain=' + window.location.protocol + '//' + window.location.host);
}

//同步登出
function syncSSOLogoutStatus() {
    var xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = eval("("+xhr.responseText+")");
            var login_status = data.code;
            if (login_status == '200') {
                location.href = bloghost + "/zb_system/cmd.php?act=logout";
            }
        }
    }
    xhr.withCredentials = true;
    xhr.open("POST", bloghost + "/zb_users/plugin/dingstudio_track/login_status_query.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send('cors_domain=' + window.location.protocol + '//' + window.location.host);
}

//访问追踪模块（由于与PJAX不兼容，现已暂时停用）
/*
$(document).ready(function(){//Wait Other JavaScript Event To Finish

    $("a").mousedown(function(){//Bind Link Click Event

        console.log('click event received...');//Output Test Message To JavaScript Console Panel

        if ((window.location.href != bloghost + 'zb_system/admin/index.php?act=admin') && (window.location.href != bloghost + 'zb_system/admin/index.php')) {
            
            this.href = this.href + "#?cpm=" + Math.random();//change link

        }

        //$("#loading-jz").remove();//Pjax Loading Animation Problem (Not Resolved)

        return true;

    });

});
*/

//TODO