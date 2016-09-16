<?php

namespace App\Controllers\UserInfo;

use App\Http\Controllers\BaseController;
use App\Models\UserInfo;
use Maatwebsite\Excel\Facades\Excel;

class UserInfoUpdateController extends BaseController
{
    protected $data;
    public function __construct()
    {
        parent::__construct();
        $this->mod = new UserInfo();
    }

    /**
     * @return mixed
     * 新增记录
     */
    public function insert()
    {
        $params = $this->validate_request();
        $id = $this->mod->insert_single($params);
        if ($id) {
            reset($params);
            $params['id'] = $id;
            $params['create_time'] = date('Y-m-d H:i:s', $params['create_time']);
            return response()->json($params);
        } else {
            $this->errorOutput('CREATE_FAILS');
        }
    }

    /**
     * @return mixed
     * 修改记录
     */
    public function update()
    {
        $this->validation(['id' => 'required | digits_between:1,11'],['id' => '用户id']);
        $id = intval($this->input['id']);
        $params = $this->validate_request();
        $res = $this->mod->update($id, $params);
        if ($res) 
            return response()->json(['success' => 1]);
        $this->errorOutput('UPDATE_FAILS');
    }

    /**
     * @return mixed
     * 删除记录
     */
    public function delete()
    {
        $this->validation(['id' => 'required |regex:/^[1-9]\d*(,\d*)*$/'],['id' => '用户id']);
        $ids = explode(',', $this->input['id']);
        $res = $this->mod->delete($ids);
        if ($res)
            return response()->json(['success' => 1]);
        $this->errorOutput('DELETE_FAILS');
    }

    /**
     * @return mixed
     * 上传文件
     */
    public function uploadExcel()
    {
        $file_old_name = $_FILES['Filedata']['name'];
        if (!empty($file_old_name)) {
            $tmp_file   = $_FILES['Filedata']['tmp_name'];
            $file_with = explode('.', $file_old_name);
            $file_type  = $file_with[count($file_with)-1];
            if (!in_array(strtolower($file_type), ['xml', 'xls', 'xlsx'])) {
                $this->errorOutput('FILE_TYPE_ERROR');
            }
            $file_new_name = date('Ymdhis').'.'.$file_type;
            $file_current_name = UPLOAD_DIR.'current.'.$file_type;
            if (!copy($tmp_file, $file_current_name) || !copy($tmp_file, UPLOAD_DIR.$file_new_name)) {
                $this->errorOutput('UPLOAD_ERROR');
            }
            return $this->import($file_current_name);
        }
    }

    /**
     * @param $file_current_name
     * @return mixed
     * 上传文件数据存储在数据库
     */
    private function import($file_current_name)
    {
        $params = [];
        Excel::load($file_current_name, function($reader) {
            $this->data = $reader->getSheet(0)->toArray();
        });
//        pre($this->data);
        unset($this->data[0]);
        unset($this->data[1]);
        foreach ($this->data as $key => $vo) {
            if ($vo[4] && $vo[6] && $vo[5] && $vo[7]) {
                $this->input = [
                    'name'            => $vo[4],
                    'tel'             => $vo[6],
                    'money'           => $vo[3],
                    'invite_code'     => $vo[5],
                    'conversion_code' => $vo[7],
                    'BD'              => $vo[8]
                ];
                $params[] = $this->validate_request();
            }
        }
        $res = $this->mod->insert_plural($params);
        if ($res)
            return response()->json(['success' => 1]);
        $this->errorOutput('CREATE_FAILS');
    }

    /**
     * @return array
     * 验证数据
     */
    private function validate_request()
    {
        $attr = [
            'name'            => 'max:32',
            'tel'             => 'alpha_dash | max:11',
            'money'           => 'alpha_dash | max:11',
            'invite_code'     => 'alpha_dash | max:6',
            'conversion_code' => 'alpha_dash | max:12',
            'BD'              => 'max:50'
        ];
        if (!$this->input['id']) {
            $attr['tel'] = 'alpha_dash | unique:mysql-userInfo.userInfo,tel| max:11'; 
            $attr['invite_code'] = 'alpha_dash | unique:mysql-userInfo.userInfo,invite_code| max:6';
            $attr['conversion_code'] = 'alpha_dash | unique:mysql-userInfo.userInfo,conversion_code| max:12';
        }
        $rules = [
            'name'            => '姓名',
            'tel'             => '用户手机号'.$this->input['tel'],
            'money'           => '查发金额',
            'invite_code'     => '邀请码'.$this->input['invite_code'],
            'conversion_code' => '兑换码'.$this->input['conversion_code'],
            'BD'              => '备注'
        ];
        $this->validation($attr, $rules);
        return [
            'name'            => $this->input['name'] ? trim($this->input['name']) : '',
            'tel'             => $this->input['tel'] ? trim($this->input['tel']) : '',
            'money'           => $this->input['money'] ? trim($this->input['money']) : '',
            'invite_code'     => $this->input['invite_code'] ? trim($this->input['invite_code']) : '',
            'conversion_code' => $this->input['conversion_code'] ? trim($this->input['conversion_code']) : '',
            'BD'              => $this->input['BD'] ? trim($this->input['BD']) : '',
            'create_time'     => TIMENOW
        ];
    }
}