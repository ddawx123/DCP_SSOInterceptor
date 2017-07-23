<?php
/**
 * @package DingStudio_SSOUtil
 * @version 1.0
 */
/*
Plugin Name: DingStudio_SSOUtil
Plugin URI: http://passport.dingstudio.cn/
Description: This is dingstudio single sign on plugin
Author: DingStudio
Version: 1.0
Author URI: http://blog.dingstudio.cn/
*/

// 挂接WordPress公用接口函数
add_action( 'login_enqueue_scripts', 'SSOLogin' );
add_action( 'wp_head', 'AddPublicJS' );

function AddPublicJS() {
	echo '<script type="text/javascript">var blog_host_path = "' . home_url() . '";</script>';
}

/**
 * WordPress 站点登录状态SSO互通
 */
function trySSOLogin() {
	$user_login = $_COOKIE['dingstudio_sso']; // 从cookie获取sso登录的用户名
	$user = get_userdatabylogin($user_login);// 获取用户资料集合
	$user_id = $user->ID;// 获取用户id
	wp_set_current_user($user_id, $user_login);// 设置用户状态
	wp_set_auth_cookie($user_id);// 设置wordpress cookie
	//do_action('wp_login', $user_login); //执行登录
	if (!is_user_logged_in()) {//再次确认上面的登录是否成功
		//SSO系统中账号在wordpress系统中并不存在，走全新自动注册流程
		return false;
	}
	else {
		return true;
	}
}

/**
 * WordPress 站点登录状态同步登入
 */
function doSSOLogin() {
	
	if (isset($_COOKIE['dingstudio_sso']) && isset($_COOKIE['dingstudio_ssotoken'])) {
		if (!trySSOLogin()) {
			//die('WordPress账号系统中不存在SSO通行证的账号');
			$userdata = array();
			$userdata['user_login'] = $_COOKIE['dingstudio_sso'];
			$userdata['user_pass'] = 'dingstudio@'.rand(100,999);
			$userdata['user_nicename'] = $_COOKIE['dingstudio_sso'];
			$userdata['user_email'] = rand(10000000,99999999).'@anonymous.dingstudio.cn';
			if (wp_insert_user($userdata)) {
				if (!isset($_POST['returnUrl']) or @$_POST['returnUrl'] == '') {
					PassportOperater(200);
				}
				else {
					PassportOperater(200,@$_POST['returnUrl']);
				}
				
			}
			else {
				printJSON(buildMsgArr(500,'Login failed ...'));
			}
		}
		else {
			if (!isset($_POST['returnUrl']) or @$_POST['returnUrl'] == '') {
				PassportOperater(200);
			}
			else {
				PassportOperater(200,@$_POST['returnUrl']);
			}
		}
	}
	else {
		if (!$_SERVER['HTTP_REFERER']) {
			PassportOperater(403);
		}
		else {
			PassportOperater(401);
		}
	}
}

/**
 * WordPress 站点登录状态同步退出
 */
function doSSOLogout() {
	if (!is_user_logged_in()) {//再次确认上面的登录是否成功
		PassportOperater(405);
	}
	else {
		wp_logout();
		if (!isset($_POST['returnUrl']) or @$_POST['returnUrl'] == '') {
			PassportOperater(200);
		}
		else {
			PassportOperater(200,@$_POST['returnUrl']);
		}
	}
}

/**
 * 通过JSON方式输出数据
 * @param array $arr 需要转换为JSON格式的数组
 * @return string 返回JSON字符串
 */
function printJSON($arr) {
	header('Content-Type: application/json; charset=UTF-8');
	die(json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
}

function printText($text) {
	header('Content-Type: text/html; charset=UTF-8');
	die($text);
}

/**
 * 通行证登录控制器
 * @param integer $resultId 返回的处理结果码
 * @param string $returnUrl 前端传入的回调页面
 * @return action 返回具体动作（如重定向）
 */
function PassportOperater($resultId, $returnUrl = null) {
	switch($resultId) {
		case 200:
		if ($returnUrl == null) {
			wp_redirect('./wp-admin/index.php',302);
		}
		else {
			wp_redirect($returnUrl,302);
		}
		break;
		case 403:
		printText('站群同步登录失败，可能的原因是您的本次访问存在安全隐患，导致站群防火墙主动拦截了本次同步登录请求。请从正确的渠道重新发起站群登录请求，如果问题依旧，请联系站点管理员！技术跟踪代码：403');
		break;
		case 401:
		printText('站群同步登录失败，可能的原因是您在其他页面退出了通行证，导致用户信息传输通道过期。请重新登录您的通行证后再次尝试！技术跟踪代码：401');
		break;
		case 500:
		printText('当前所登录的通行证帐户首次登录该WordPress站点，但是系统在同步数据和自动注册流程时WordPress系统返回了异常状态。发生该错误可能是由于WordPress站点所在数据库的空间占用已经饱和或站群互联出现异常，请联系站点管理员解决此问题！技术跟踪代码：500');
		break;
		case 405:
		printText('站群登录状态当前暂时无权更改，可能的原因是您本次访问的页面状态已经过期。建议返回主页后继续操作！技术跟踪代码：405');
		break;
		default:
		printText('由于WordPress返回了未知代码，导致站群同步登录无法继续。可能的原因是系统正在升级或站群通行证正处于维护状态。请稍后再次尝试！技术跟踪代码（或不存在）：'.$resultId);
		break;
	}
}

function buildMsgArr($code, $message) {
	$home_Url = home_url();
	$arr = array(
		code => $code,
		message => $message,
		siteRoot => $home_Url,
		requestId => date('Ymdhis',time())
	);
	return $arr;
}

function SSOLogin() {
	if (@$_GET['action'] == 'SSOController') {
		if (@$_GET['operate'] == 'Login') {
			ob_clean();
			doSSOLogin();
		}
		else if (@$_GET['operate'] == 'Logout') {
			ob_clean();
			doSSOLogout();
		}
		else {
			ob_clean();
			printJSON(buildMsgArr(-1,'Unable found function module ...'));
		}
	}
}

?>
