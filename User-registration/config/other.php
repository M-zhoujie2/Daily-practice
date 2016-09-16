<?php
/**
 * Created by PhpStorm.
 * User: zhoujie
 * Date: 16/7/3
 * Time: 下午2:33
 */
return [
    /*****************2016.7.3 微信登录配置***************/
    'wechat-dev' => [
        'param' => [
            'appid' => 'wxa930c91b5e6dfa3c',
            'secret'=> '7ce117a52e022e98da32617085819988',
        ],
        'api' => [
            'token' => 'https://api.weixin.qq.com/sns/oauth2/access_token',
            'user'  => 'https://api.weixin.qq.com/sns/userinfo',
            'valid_token' => 'https://api.weixin.qq.com/sns/auth'
        ],
    ],
    /*****************2016.7.3 微信登录配置 结束***********/
];