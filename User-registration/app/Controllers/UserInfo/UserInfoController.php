<?php

namespace App\Controllers\UserInfo;

use App\Http\Controllers\BaseController;
use App\Models\UserInfo;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Translation\Tests\Writer\BackupDumper;

class UserInfoController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->mod = new UserInfo();
    }

    /**
     * @return array
     * 数据列表
     */
    public function lists()
    {
        $data = [];
        $params = $this->validate_request();
        $lists = json_decode($this->mod->lists($params), 1);
        foreach ($lists['data'] as $vo) {
            $vo['create_time'] = date('Y-m-d H:i:s', $vo['create_time']);
            $data[] = $vo;
        }
        unset($lists['data']);
        return ['data' => $data, 'pageInfo' => $lists];
    }


    /**
     * 获取下载列表
     */
    public function downloadExcel()
    {
        $lists = (array)$this->mod->all_lists();
        if (!$lists || !is_array($lists)) {
            $this->errorOutput('DATA_FAILS');
        }
        foreach ($lists as $key => $vo) {
            $data[] = [
                $vo->id, $vo->name, $vo->tel,
                $vo->money, $vo->invite_code,
                $vo->conversion_code, $vo->BD,
                date('Y-m-d H:i:s', $vo->create_time)
            ];
        }
        array_unshift($data, ['序号', '姓名', '移动电话', '投资金额', '邀请码', '兑换码', '备注', '登记时间']);
        $this->export($data);
    }

    /**
     * @param $data
     * 将列表转换成Excel表格
     */
    private function export($data){
        Excel::create('用户登记表',function($excel) use ($data){
            $excel->sheet('第一页', function($sheet) use ($data) {
                $num = [];
                for ($i = 2; $i <= count($data)+1; $i++) {
                    $num[$i] = 25;
                };
                $sheet->rows($data)->prependRow(1, ['用户数据登记表'])->mergeCells('A1:H1')->cell('A1:H1', function($cell) {
                    $cell->setAlignment('center')->setValignment('center')->setFont([
                        'family'     => 'Calibri',
                        'size'       => '16',
                        'bold'       =>  true
                    ]);
                })->cell('A2:H2', function($cell) {
                    $cell->setAlignment('center')->setValignment('center')->setFont([
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true
                    ]);
                })->cell('A3:H'.(count($data)+1), function($cell) {
                    $cell->setAlignment('center')->setValignment('center');
                })->setAutoSize(true)->setHeight([1 => 50])->setHeight(
                    $num
                )->setWidth([
                    'A' => 10, 'B' => 10, 'C' => 15, 'D' => 15,
                    'E' => 15, 'F' => 20, 'G' => 15, 'H' => 20
                ]);
            });
        })->export('xls');
    }

    /**
     * @return array
     * 验证数据
     */
    private function validate_request()
    {
        $this->validation([
            'title'       => 'max:32',
            'start_time' => '',
            'end_time'   => '',
            'page'       => 'numeric',
            'count'      => 'numeric'
        ],[
            'title'      => '查询标题',
            'start_time' => '开始时间',
            'end_time'   => '结束时间',
            'page'       => '分页页数',
            'count'      => '分页数据'
        ]);
        return [
            'title'      => $this->input['title'] ? trim($this->input['title']) : '',
            'start_time' => $this->input['start_time'] ? strtotime($this->input['start_time']) : '',
            'end_time'   => $this->input['end_time'] ? strtotime($this->input['end_time']) : TIMENOW,
            'page'       => $this->input['page'] ? intval($this->input['page']) : 1,
            'count'      => $this->input['count'] ? intval($this->input['count']) : 20
        ];
    }
}