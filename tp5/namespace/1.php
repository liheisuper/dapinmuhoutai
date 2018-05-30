<?php 
//define   const  定义常量
// 常量前面没有美元符号（$）；
// 常量只能用 define() 函数定义，而不能通过赋值语句；
// 常量可以不用理会变量的作用域而在任何地方定义和访问；
// 常量一旦定义就不能被重新定义或者取消定义；
// 常量的值只能是标量。


// define("cont", "cont");
// const cont = 11221323;
/**
* 	命名空间解决了函数的全局命名冲突问题
* 	如果代码使用了命名空间，那么所有的代码必须写到命名空间中去
*/

/**
 * 函数的命名空间
 */
// namespace a{
// 	function hello()
// 	{
// 		return "命名空间是".__NAMESPACE__."函数名称是".__FUNCTION__;
// 	}
// }

// namespace b{
// 	function hello()
// 	{
// 		return "命名空间是".__NAMESPACE__."函数名称是".__FUNCTION__;
// 	}
// }

// namespace 
// {
// 	echo \a\hello();
// 	echo "<hr>";
// 	echo \b\hello();
// }
// echo 123;die;
// function hello()
// {
// 	echo "函数名称是".__FUNCTION__;
// }
// function hello()
// {
// 	echo "又一个函数名称是".__FUNCTION__;
// }
// echo hello();
// echo "<hr>";
// echo hello();
/**
 * 类的命名空间
 */
// namespace a{	
// 	class A
// 	{
// 		public $name = "samll pig";
// 		function hello()
// 		{
// 			$namespace = "命名空间:".__NAMESPACE__;
// 			$calssname = "类名:".__CLASS__;
// 			$function  = "方法名:".__FUNCTION__;
// 			return $namespace.'<br>'.$calssname.'<br>'.$function.'<br>';
// 		}
// 	}	
// }
// namespace b{
// 	class B
// 	{
// 		public $name = "big pig";
// 		function hello()
// 		{
// 			$list = new \a\A;
// 			$name = $list->name;
// 			// return $name;
// 			$a    = $list->hello();
// 			$calssname = "类名:".__CLASS__;
// 			$function  = "方法名:".__FUNCTION__;
// 			return $calssname.'<br>'.$function.'<br>'.$name.'<br>'.$a;
// 		}
// 	}
// }
// namespace
// {
// 	// $list = new a\A;
// 	// echo $list->hello();
// 	echo (new a\A)->hello();
// 	echo "<hr>";
// 	$list = new b\B;
// 	echo $list->hello();
// }
/**
 * 常量的命名空间
 * define('常量名称','value') define函数声明的变量 不收命名空间限制
 * const 常量名称 = 'value' const关键字声明的常量 访问受命名空间的限制
 */
// namespace a{
// 	define('is' , 'lova');
// }
// namespace b{
// 	const it = 'lova';
// }
// namespace{
// 	echo is;
// 	echo '<br>';
// 	echo \b\it;
// }
// define('is','123');
// namespace app\index;
// const it = '123';
// // use  const app\index as C;
// echo \app\index\it;
// $app = 'json';
// print_r($app[0]);
// class Danli{
// 	static private $_instance = null;
// 	private function __construct()
// 	{
// 		echo "这是一个单利".'<br>';
// 	}
// 	static public function getInstance()
// 	{
// 		if(!(self::$_instance instanceof Danli))
// 		{
// 			echo "实例化单利".'<br>';
// 			self::$_instance = new self;
// 		}
// 		return self::$_instance;
// 	}
// 	public function ee()
// 	{
// 		echo "完成".'<br>';
// 	}
// }
// $aa = Danli::getInstance();
// $bb = $aa->ee();
// echo $bb.'<hr>';
// $aa = Danli::getInstance();
// $bb = $aa->ee();
// echo $bb;
// class XiaozhuaiSingleton
// {
//     // 私有化构造方法
//     private function __construct()
//     {
//     	echo '1'.'<br>';
//     }

//     // 私有化clone方法
//     private function __clone()
//     {

//     }


//     // 保存实例的静态对象
//     private static $singleInstance;

//     /**
//      * 声明静态调用方法
//      * 目的：保证该方法的调用全局唯一
//      *
//      * @return XiaozhuaiSingleton
//      */
//     public static function getInstance()
//     {
//         if (!self::$singleInstance) {
//             self::$singleInstance = new self();
//         }

//         return self::$singleInstance;
//     }


//     // 调用单例的方法
//     public function singletonFunc()
//     {
//         echo "完成一次".'<br>';
//     }

// }

// $singleInstance = XiaozhuaiSingleton::getInstance();
// $singleInstance->singletonFunc();

// $singleInstance2 = XiaozhuaiSingleton::getInstance();
// $singleInstance2->singletonFunc();

// // 校验是否是一个实例
// var_dump($singleInstance === $singleInstance2);  // true ，一个对象
// namespace Frame;
// // use Frame\Database;
// // use Frame\Register;

// class Factory
// {
//     static function createDatabase()
//     {
//         //$db = new Database(); //正常实例化类
//         $db = Database::getInstance();    //获取单例模式的类
//         Register::set('db',$db);          //将实例化后的类注册到全局注册树中
//         return $db;
//     }
//     public function aa()
//     {
//     	echo 123;die;
//     }
// }
// //外部调用得到$db对象
// $db = Frame\Factory::createDatabase();//获取全局注册树中的对象
// $ee = $db->aa();
// echo $ee;die;
// $db = Frame\Register::get('db');
// //卸载全局注册树中的对象
// $db = Frame\Register::_unset('db');
header('Content-Type:text/html;charset=utf-8');
/**
 *简单工厂模式（静态工厂方法模式）
 */

/**
 * Interface people 人类
 */
interface  people
{
    public function  say();
}

/**
 * Class man 继承people的男人类
 */
class man implements people
{
    // 具体实现people的say方法
    public function say()
    {
        echo '我是男人<br>';
    }
}

/**
 * Class women 继承people的女人类
 */
class women implements people
{
    // 具体实现people的say方法
    public function say()
    {
        echo '我是女人<br>';
    }
}

/**
 * Class SimpleFactoty 工厂类
 */
class SimpleFactoty
{
    // 简单工厂里的静态方法-用于创建男人对象
    static function createMan()
    {
        return new man();
    }

    // 简单工厂里的静态方法-用于创建女人对象
    static function createWomen()
    {
        return new women();
    }

}

/**
 * 具体调用
 */
$man = SimpleFactoty::createMan();
$man->say();
$woman = SimpleFactoty::createWomen();
$woman->say();