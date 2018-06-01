<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;

class Picture extends Controller
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
	// 中药材示范区
    public function demonstration()
    {
        // 读取文件
        return $this->images(0);
    }
    // 中药材产品
    public function product()
    {
        // 读取文件
        return $this->images(1);
    }
    // 优秀企业
    public function excellent()
    {
        // 读取文件
        return $this->images(2);
    }
    // 优秀企业产品
    public function quality()
    {
        // 读取文件
        return $this->images(3);
    }

    //组装图片放回信息
    public function images($status)
    {
        // 读取文件
        $picture = Db::name('picture')->where('status',$status)->column('file_path');
        foreach ($picture as $key => $value) {
            $image[$key] = __ARR__.$value;
        }
        if($picture)
        {
        	return $this->returnMsg('1000','成功',$image);
        }
        else
        {
        	return $this->returnMsg('1007','获取信息失败',$image);
        }
    }

    // 上涨品种
    public function rise()
    {
        $status = 0;
        $this->variety($status);
    }
    // 下跌品种
    public function tumble()
    {
        $status = 1;
        $this->variety($status);
    }

    // 跌涨情况
    public function variety($status)
    {
        $picture = Db::name('variety')->where('status',$status)->select();
        if($picture)
        {
            return $this->returnMsg('1000','成功',$picture);
        }
        else
        {
            return $this->returnMsg('1007','获取信息失败',$picture);
        }
    }

    //求供信息
    public function supply()
    {
        //供应
        $status = 0;
        $this->deal($status);
    }

    // 求购信息
        public function buy()
    {
        //供应
        $status = 1;
        $this->deal($status);
    }

    //组装供求信息
    public function deal($status)
    {
        $picture = Db::name('deal')->where('status',$status)->select();
        if($picture)
        {
            return $this->returnMsg('1000','成功',$picture);
        }
        else
        {
            return $this->returnMsg('1007','获取信息失败',$picture);
        }

    }


    //市场价格
    public function bazaar()
    {
        $picture = Db::name('market_price')->select();
        // print_r($picture);die;
        foreach ($picture as $key=>$value){
          $id[$key] = $value['statistics_time'];
        }
        array_multisort($id,SORT_ASC,$picture);

        foreach($picture as $item) {
          $date[$item['drug']][$item['agora']][$item['id']]['id'] = $item['id'];
          $date[$item['drug']][$item['agora']][$item['id']]['statistics_time'] = substr($item['statistics_time'],0,-6);
          $date[$item['drug']][$item['agora']][$item['id']]['price'] = $item['price'];
        }
        foreach ($date as $key => $value) {
            foreach ($value as $k => $val) {
                $new = array_values($val);
                foreach($new as $item) {
                  $data[$item['statistics_time']][] = $item['price'];
                }
                $date[$key][$k] = $data;
            }
        }
        return $this->returnMsg('1000','成功',$date);
        // $aa = array_values_count($picture);
        for ($i=0; $i < count($picture); $i++) { 
            for ($j=1; $j < count($picture); $j++) { 
                if($picture[$i]['drug']==$picture[$j]['drug']&&$picture[$i]['agora']==$picture[$j]['agora'])
                {
                    
                }
            }
        }
        print_r($date);die;

    }


    /**
     * @param $error_code int 错误返回码
     * @param $msg  string  错误信息
     * @param $data array  返回数据
     */
    public function returnMsg($code,$msg,$data)
    {
        $data=['error_code'=>$code,'msg'=>$msg,'date'=>$data];
        echo json_encode($data,JSON_UNESCAPED_UNICODE);exit;
    }

}

 ?>