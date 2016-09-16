<?php
/**
 * Created by PhpStorm.
 * User: zhoujie
 * Date: 16/5/10
 * Time: 下午11:28
 */
/**
 * 打印
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);exit;
}
/**
 * 处理用户信息
 */
function process_userinfo($user)
{
    if(!is_array($user) && !is_object($user)) {
        return false;
    }
    if(is_array($user)) $user = json_decode(json_encode($user)); 
    $userinfo = [
        'user_id' => $user->id,
        'user_name' => $user->name,
        'age' => $user->age,
        'phone' => $user->phone,
        'email' => $user->email,
    ];
    return $userinfo;
}

function RandomStr($length = '')
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key.=$str{rand(0,35)};
    }
    return $key;
}

function arraySort($array, $key, $type)
{
    $keyArray = $newArray = [];
    foreach($array as $k => $v) {
        $keyArray[$k] = $v[$key];
    }
    if($type == 'asc') {
        asort($keyArray);
    }else{
        arsort($keyArray);
    }
    foreach($keyArray as $k => $v) {
        $newArray[] = $array[$k];
    }
    return $newArray;
}