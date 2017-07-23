<?php

require '../../../zb_system/function/c_system_base.php';

require '../../../zb_system/function/c_system_admin.php';

$zbp->Load();

header('Content-Type: application/json; charset=UTF-8');

if (!isset($_POST['cors_domain']) or $_POST['cors_domain'] == '') {
    $arr = array(
        'code'  =>  403,
        'message'   =>  'No do no die, conduct oneself well.'
    );
    die(json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
}

if (!$zbp->CheckRights('root')) {
    $arr = array(
        'code'  =>  401,
        'message'   =>  'Not yet logged in.'
    );
    die(json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
}
else {
    $arr = array(
        'code'  =>  200,
        'message'   =>  'You are logged in.'
    );
    die(json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
}