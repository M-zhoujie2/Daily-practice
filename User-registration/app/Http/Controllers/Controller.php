<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as iController;

class InitController extends iController
{
    protected $input;
    public function __construct()
    {
        $this->input = Request::input();
    }
    
    public function errorOutput($errno = '',$atti = [],$errText = '')
    {
        $ret = [
            'ErrorCode' => $errno,
            'ErrorText' => $errText ? $errText : trans('errors.'.$errno,$atti)
        ];
        $header = [
            'Access-Control-Allow-Origin' => Request::header('Origin'),
            'Access-Control-Allow-Credentials' => Config::get('cors.supportsCredentials') ? 'true' : 'false',
        ];
        $response = JsonResponse::create($ret,200,$header);
        $response->send();
        exit;
    }
    
    public function handleErrorOutput($errno = '',$errortext = '')
    {
        $this->errorOutput($errno,[],$errortext);
    }
    
    public function validation($rules = [],$attr = [],$info = [],$error = [])
    {
        $info = $info ? $info : $this->input;
        $validator = Validator::make($info,$rules,$error,$attr);
        if($validator->fails()){
            $keys = $validator->errors()->keys();
            return $this->handleErrorOutput(strtoupper($keys[0]),$validator->errors()->first());
        }else{
            return false;
        }
    }
}

class BaseController extends InitController
{
    public function __construct()
    {
        parent::__construct();
        
    }
}
