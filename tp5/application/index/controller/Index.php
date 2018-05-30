<?php
namespace app\index\controller;
use \think\Controller;
use app\index\model\OutputNew;
use think\Config;
use think\View;
class Index extends Controller 
{
     public function _initialize()
     {
        // 指定允许其他域名访问    
        header('Access-Control-Allow-Origin:*');    
        // 响应类型    
        header('Access-Control-Allow-Methods:POST');    
        // 响应头设置    
        header('Access-Control-Allow-Headers:x-requested-with,content-type'); 
     }
    public function index()
    {
        return $this->fetch('index');
    }
    //demo
    //五月产新品种
    public function test()
    {
        //当前月份
        $month       = date('n');
        $outputmodel = new OutputNew();
        $present     = $outputmodel->where('month',$month)->column('id,name');
        $present     = implode(',',$present);
        $next_present= $outputmodel->where('month',$month+1)->column('id,name');
        $next_present= implode(',',$next_present);
        $output['month']   = $month;
        $output['present'] = $present;
        $output['next_present'] = $next_present;
        return json_encode($output,JSON_UNESCAPED_UNICODE);
    }
}
