<?php 
	// include('1.php');
	// echo is;
	// namespace app;
	// // echo cont;
	// // use  const app\index as C;
	// // echo C;
	// echo \app\index\it;
	// interface poeple 
	// {
	// 	public function say();
	// }
	// class man implements poeple
	// {
	// 	public function say()
	// 	{
	// 		echo "你是男人".'<br>';
	// 	}
	// }
	// class women implements poeple
	// {
	// 	public function say()
	// 	{
	// 		echo "你是女人".'<br>';
	// 	}
	// }
	// class sim
	// {
	// 	static function creaman()
	// 	{
	// 		return new man();
	// 	}
	// 	static function creaawoman()
	// 	{
	// 		return new women();
	// 	}	
	// }
	// $man = sim::creaman();
	// $man ->say();
	// $women=sim::creaawoman();
	// $women->say();
// header('Content-type:text/html;charset=utf-8');
// /*
//  *工厂方法模式
//  */

// /**
//  * Interface people 人类
//  */
// interface  people
// {
//     public function  say();
// }

// /**
//  * Class man 继承people的男人类
//  */
// class man implements people
// {
//     // 实现people的say方法
//     function say()
//     {
//         echo '我是男人-hi<br>';
//     }
// }

// /**
//  * Class women 继承people的女人类
//  */
// class women implements people
// {
//     // 实现people的say方法
//     function say()
//     {
//         echo '我是女人-hi<br>';
//     }
// }

// /**
//  * Interface createPeople 创建人物类
//  * 注意：与上面简单工厂模式对比。这里本质区别在于，此处是将对象的创建抽象成一个接口。
//  */
// interface  createPeople
// {
//     public function create();

// }

// /**
//  * Class FactoryMan 继承createPeople的工厂类-用于实例化男人类
//  */
// class FactoryMan implements createPeople
// {
//     // 创建男人对象（实例化男人类）
//     public function create()
//     {
//         return new man();
//     }
// }

// /**
//  * Class FactoryMan 继承createPeople的工厂类-用于实例化女人类
//  */
// class FactoryWomen implements createPeople
// {
//     // 创建女人对象（实例化女人类）
//     function create()
//     {
//         return new women();
//     }
// }

// /**
//  * Class Client 操作具体类
//  */
// class  Client
// {
//     // 具体生产对象并执行对象方法测试
//     public function test() {
//         $factory = new FactoryMan();
//         $man = $factory->create();
//         $man->say();

//         $factory = new FactoryWomen();
//         $man = $factory->create();
//         $man->say();
//     }
// }

// // 执行
// $demo = new Client;
// $demo->test();
// function say(){
// 	$arr   = [5,3,1,9,2,4];
// 	$count = count($arr);
// 	$man   = '';
// 	for ($i=0; $i <$count-1 ; $i++) { 
// 		for ($j=0; $j < $count-$i-1; $j++) { 
// 			if($arr[$j]>$arr[$j+1])
// 			{
// 				$man    = $arr[$j];
// 				$arr[$j]= $arr[$j+1];
// 				$arr[$j+1]= $man;
// 			}
// 			// print_r($arr);
// 		}
// 	}
// 	return $arr;
// }
// print_r(say());
// 选择排序
//  function selection_sort($array){
//     $count=count($array);
//     for($i=0;$i<$count-1;$i++){
//         /*findtheminest*/
//         $min=$i;
//         // echo'$min-->'.$array[$min].'-->';
//         for($j=$i+1;$j<$count;$j++){
//             //由小到大排列
//             if($array[$min]>$array[$j]){
//                 //表明当前最小的还比当前的元素大
//                 $min=$j;
//                 //赋值新的最小的
//             }
//         }
//         // echo$array[$min].'coco<br/>';
//         /*swap$array[$i]and$array[$min]即将当前内循环的最小元素放在$i位置上*/
//         if($min!=$i){
//             $temp=$array[$min];
//             $array[$min]=$array[$i];
//             $array[$i]=$temp;
//         }
//     }
//     return$array;
// }
// print_r(selection_sort([5,3,1,9,2,4]));
//快速插入
// function quick_sort($arr)
//     {
//         //判断参数是否是一个数组
//         if(!is_array($arr)) 
//            return false;
//         //递归出口:数组长度为1，直接返回数组
//         $length=count($arr);
//         if($length<=1) return $arr;
//         //数组元素有多个,则定义两个空数组
//         $left=$right=array();
//         //使用for循环进行遍历，把第一个元素当做比较的对象
//         for($i=1;$i<$length;$i++)
//         {
//             //判断当前元素的大小
//             if($arr[$i]<$arr[0]){
//                 $left[]=$arr[$i];
//             }else{
//                 $right[]=$arr[$i];
//             }
//         }
//         //递归调用
//         $left=quick_sort($left);
//         $right=quick_sort($right);
//         //将所有的结果合并
//         return array_merge($left,array($arr[0]),$right);
//         }
// print_r(quick_sort([5,3,1,9,2,4]));

//随机生成数值数组
for($i=0;$i<10;$i++){
  $ary[]=rand(1,1000);
}
//统计数组中所有的值出现的次数
$ary = [1,2,3,4,1,2,3,4,4,6,7,7,7,8,9,8,7,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,10,4,24,56,89,43];
$ary=array_count_values($ary);
arsort($ary);//倒序排序
$ary = array_slice($ary,0,10);
print_r($ary);die;
// print_r($ary);die;
$i=1;
foreach($ary as $key=>$value){
  if($i<=10){
    printf("数字：%d 共出现 %d 次<br/>",$key,$value); 
  }else{
    break;
  }
  $i++;
}
unset($ary);