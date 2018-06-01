<?php
/**
 * Created by PhpStorm.
 * User: xujiantong
 * Email: 314783087@qq.com
 * Date: 2018/1/12
 * Time: 16:49
 */
namespace app\index\controller;

use think\Controller;
use think\Loader;
use think\File;
use think\Db;

// use PHPExcel;
// use PHPExcel_IOFactory;
// use PHPExcel_Cell;
class Te extends Controller
{
    public function test()
    {
        return $this->fetch();
    }

    public function tablebig()
    {
        return $this->fetch();
    }

    //导入Excel
    public function into()
    {
        if (!empty ($_FILES ['file_stu'] ['name'])) {
            $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
            $file_types = explode(".", $_FILES ['file_stu'] ['name']);
            $file_type = $file_types [count($file_types) - 1];
            /*判别是不是.xls文件，判别是不是excel文件*/
            if (strtolower($file_type) != "xlsx") {
                $this->error('不是Excel文件，重新上传');
            }
            /*设置上传路径*/
            /*百度有些文章写的上传路径经过编译之后斜杠不对。不对的时候用大写的DS代替，然后用连接符链接就可以拼凑路径了。*/
            $savePath = ROOT_PATH . 'public' . DS . 'uploads' . DS;/*以时间来命名上传的文件*/
            $str = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            
            /*是否上传成功*/
           
            if (!copy($tmp_file, $savePath . $file_name)) {
                $this->error('上传失败');
            }
            /*
            *对上传的Excel数据进行处理生成编程数据,这个函数会在下面第三步的ExcelToArray类中
            *注意：这里调用执行了第三步类里面的read函数，把Excel转化为数组并返回给$res,再进行数据库写入
            */
           // echo THINK_PATH;die;
            // require THINK_PATH.'library/think/ExcelToArrary.php';//导入excelToArray类
            Loader::import('ExcelToArrary',EXTEND_PATH);
          //引入这个类试了百度出来的好几个方法都不行。最后简单粗暴的使用了require方式。这个类想放在哪里放在哪里。只要路径对就行。
         
            $ExcelToArrary = new \ExcelToArrary();//实例化
            
            $res=$ExcelToArrary->read($savePath.$file_name,"UTF-8",$file_type);//传参,判断office2007还是office2003
            unset($res[1]);
           // print_r($this->excelTime($res[2][2]));die;
            /*对生成的数组进行数据库的写入*/
            // 市场价格
            $a = 0;
            $b = 1;
            foreach ($res as $k => $v) {
                if ($k > 1) {
                    // $a = 0;
                    $a++;
                    $b++;
                    $data[$k]['drug'] = '第一种药';                    
                    $data[$k]['agora'] = '泰国';
                    // echo strlen($a);die;
                    if($a>=13)
                    {
                        $a = 1;
                    }
                    if(strlen($a)<=1)
                    {
                        $a = '0'."$a";
                    }
                    $data[$k]['statistics_time'] = '2018-'.$a.'-01';
                    // $data[$k]['statistics_time'] = $this->excelTime($v[2]);
                    $data[$k]['price'] = $b;
                    // $data[$k]['price'] = $v[3];
                    $data[$k]['create_time'] = time();

                }
            }
            // print_r($data);die;
            // alert($a);die;
            // 涨跌
            // foreach ($res as $k => $v) {
            //     if ($k > 1) {
            //         $data[$k]['drug'] = $v[0];                    
            //         $data[$k]['exponent'] = $v[1];
            //         $data[$k]['status'] = 1;
            //     }
            // }
            // 供求信息
            // foreach ($res as $k => $v) {
            //     if ($k > 1) {
            //         //药品名称
            //         $data[$k]['drug'] = $v[0];
            //         //规格
            //         $data[$k]['size'] = $v[1];                
            //         //产地
            //         $data[$k]['place'] = $v[2];                
            //         // 数量
            //         $data[$k]['number'] = $v[3];                
            //         //价格
            //         $data[$k]['price'] = $v[4];                
            //         //联系人
            //         $data[$k]['contact'] = $v[5];                
            //         //联系电话
            //         $data[$k]['del'] = $v[6]; 
            //         //供求关系               
            //         $data[$k]['status'] = 2;
            //         //添加时间
            //         $data[$k]['create_time'] = time();
            //     }
            // }
            // print_r($data);die;

            
            //插入的操作最好放在循环外面

            $result = DB::name('market_price')->insertAll($data);
            // print_r($result);die;
            
            if($result){
                return ['state'=>true, 'msg'=>'导入成功'];
            }else{
                return ['state'=>false, 'msg'=>'导入失败'];
            }

        }

    }
        //excel修改时间格式
        public function excelTime($date, $time = false) {
            if (function_exists('GregorianToJD')) {
                if (is_numeric($date)) {
                    $jd = GregorianToJD(1, 1, 1970);
                    $gregorian = JDToGregorian($jd + intval($date) - 25569);
                    $date = explode('/', $gregorian);
                    $date_str = str_pad($date[2], 4, '0', STR_PAD_LEFT) . "-" . str_pad($date[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($date[1], 2, '0', STR_PAD_LEFT) . ($time ? " 00:00:00" : '');
                    return $date_str;
                }
            } else {
                $date = $date > 25568 ? $date + 1 : 25569; /*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
                $ofs = (70 * 365 + 17 + 2) * 86400;
                $date = date("Y-m-d", ($date * 86400) - $ofs) . ($time ? " 00:00:00" : '');
            }
            return $date;
        }

    function index()
    {
        // echo ROOT_PATH;die;
        if(request()->isPost()) {

            Loader::import('PHPExcel.PHPExcel',EXTEND_PATH);
            Loader::import('PHPExcel.PHPExcel.PHPExcel_IOFactory',EXTEND_PATH);
            Loader::import('PHPExcel.PHPExcel.PHPExcel_Cell',EXTEND_PATH);
            //实例化PHPExcel
            $objPHPExcel = new \PHPExcel();
            $file = request()->file('excel');
            // print_r($_FILES ['excel'] ['name']);die;

            if ($file) {

                $file_types = explode(".", $_FILES ['excel'] ['name']); // ["name"] => string(25) "excel文件名.xls"
                $file_type = $file_types [count($file_types) - 1];//xls后缀
                $file_name = $file_types [count($file_types) - 2];//xls去后缀的文件名
                /*判别是不是.xls文件，判别是不是excel文件*/
                if (strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx") {
                    echo '不是Excel文件，重新上传';
                    die;
                }

                // $fileD = new \File();

                $info = $file->move(ROOT_PATH . 'public' . DS . 'excel');//上传位置
                $path = ROOT_PATH . 'public' . DS . 'excel' . DS;
                $file_path = $path . $info->getSaveName();//上传后的EXCEL路径
                echo $file_path;//文件路径

                //获取上传的excel表格的数据，形成数组
                $re = $this->actionRead($file_path, 'utf-8');
                array_splice($re, 1, 0);
                unset($re[0]);
                //dump($re); //查看数组

                /*将数组的键改为自定义名称*/
                $keys = array('jgmc', 'qymc', 'sshy', 'jrcp', 'ffje', 'fkrq', 'dqrq', 'ylv', 'bzfs', 'dkxt', 'dbdw');
                foreach ($re as $i => $vals) {
                    $re[$i] = array_combine($keys, $vals);
                }

                //遍历数组写入数据库
                for ($i = 1; $i < count($re); $i++) {
                    $data = $re[$i];
                    $res = db('ceshi')->insert($data);
                }
            }
        }


        return view();
    }


    //导出Excel
    public function out()
    {   
        //导出
        $path = dirname(__FILE__); //找到当前脚本所在路径
        vendor("PHPExcel.PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Writer.IWriter");
        vendor("PHPExcel.PHPExcel.Writer.Abstract");
        vendor("PHPExcel.PHPExcel.Writer.Excel5");
        vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);


        // 实例化完了之后就先把数据库里面的数据查出来
        $sql = model('ProductAccess')->select();

        // 设置表头信息
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', '机型')
        ->setCellValue('B1', '机型编号')
        ->setCellValue('C1', '生产日期');

        /*--------------开始从数据库提取信息插入Excel表中------------------*/

        $i=2;  //定义一个i变量，目的是在循环输出数据是控制行数
        $count = count($sql);  //计算有多少条数据
        for ($i = 2; $i <= $count+1; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i-2]['pname']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i-2]['access']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i-2]['jointime']);
        }

        
        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->setTitle('productaccess');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //通过PHPExcel_IOFactory的写函数将上面数据写出来
        
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007");
            
        header('Content-Disposition: attachment;filename="设备列表.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
        
    }

    public function images()
    {
        return $this->fetch();
    }



    //单文件上传
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
//       print_r($file);die;
        
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
//            print_r($info);die;
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                // echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                // echo $info->getFilename(); 
            }else{
                // echo 123;die;
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }

        else
        {
            return $this->fetch();
        }
    }

    //多文件上传
    public function uploads()
    {
        $files = request()->file('image');
        // print_r($files);die;
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            // print_r($info);
            if($info){
                // 入库
                $fileimg = $info->getsaveName();
                DB::name('picture')->insert(['file_path'=>$fileimg,'create_time'=>time()]);
                // 成功上传后 获取上传信息
                // 输出 jpg
                // echo $info->getsaveName(); 
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                // echo $info->getFilename(); 
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }    
        }
    }

    public function ajaxdemo()
    {
        return $this->fetch();
    }


}