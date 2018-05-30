<?php 
namespace app\index\model;

use think\Model;

class OutputNew extends Model
{
	//返回产新品种
	public function output($month)
	{
		return $month;
	}
}

 ?>