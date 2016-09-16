<?php
/**
 * Created by PhpStorm.
 * User: zhoujie
 * Date: 16/9/10
 * Time: 下午3:23
 */
namespace App\Models;

use App\Model\Base;
use Illuminate\Support\Facades\DB;

class UserInfo extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::connection('mysql-userInfo');
    }
    
    public function lists($data = [])
    {
        $sql = $this->db->table('userInfo');
        if ($data['title']) {
            $sql->where('name', 'like', '%'.$data['title'].'%')->orWhere('tel', 'like', '%'.$data['title'].'%');
        }
        return $sql->orderBy('create_time','desc')->paginate($data['count'])->tojson();
    }

    public function all_lists()
    {
        return $this->db->table('userInfo')->get();
    }
    
    public function insert_single($data = [])
    {
        if (!$data && !is_array($data))
            return false;
        return $this->db->table('userInfo')->insertGetId($data);
    }

    public function insert_plural($data = [])
    {
        if (!$data && !is_array($data))
            return false;
        return $this->db->table('userInfo')->insert($data);
    }
    
    public function update($id = '', $data = [])
    {
        if (!$data && !is_array($data))
            return false;
        return $this->db->table('userInfo')->where('id', $id)->update($data);
    }
    
    public function delete($ids = [])
    {
        if (!$ids && !is_array($ids))
            return false;
        return $this->db->table('userInfo')->whereIn('id', $ids)->delete();
    }
}