<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * DuckEngine
 *
 * 基于CodeIgniter开源框架实现的简单内容管理系统
 *
 * @package		DuckEngine
 * @author		LiTianWen
 * @copyright	Copyright (c) 2006 - 2013, LiTianWen.
 * @license		http://DuckEngine.com/license.html
 * @link		http://DuckEngine.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * DuckEngine 验证码类
 *
 * @package		DuckEngine	
 * @subpackage	libraries
 * @category	libraries
 * @author		LiTianWen
 * @link		http://DuckEngine.com
 */
class Verify{
	//宽
	protected $width=100;
	//高
	protected $height=30;
	//图片类型
	protected $imgType='jpeg';
	//字符串类型
	protected $type=3;
	//个数
	protected $num=4;
	//图片资源
	protected $img;
	//验证码字符串
	protected $checkCode;

	public function __construct($config = array()){
		if(count($config) > 0){
			foreach($config as $key => $val){
				$this->$key = $val;
			}
		}
		$this->checkCode = $this->getCheckCode();

		log_message('debug', 'Verify class Initialize');
	}

	//得到验证码字符串
	protected function getCheckCode(){
		//type=1 0-9	type=2 a-z	type=3 a-zA-Z0-9
		$string = '';
		switch($this->type){

			case 1:
				$string = join('',array_rand(range(0,9),$this->num));
				break;
			case 2:
				$string = implode('',array_rand(array_flip(range('a','z')),$this->num));
				break;
			case 3:
				/*
				for($i=0;$i<$this->num;$i++){
					$rand = mt_rand(0,2);
					switch($rand){

						case 0:
							$char = mt_rand(48,57);
							break;
						case 1:
							$char = mt_rand(65,90);
							break;
						case 2:
							$char = mt_rand(97,122);
							break;
					}
					//也可以使用chr()函数，将ASCII码转换为字符串
					$string .= sprintf('%c',$char);
				}
				*/
				$str = 'abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
				$string = substr(str_shuffle($str),0,$this->num);
				break;
		}
		return $string;
	}


	//生成画布
	protected function createImg(){

		$this->img = imagecreatetruecolor($this->width,$this->height);
	}


	//分配背景颜色
	protected function bgColor(){

		return imagecolorallocate($this->img,mt_rand(130,255),mt_rand(130,255),mt_rand(130,255));
	}


	//分配字体颜色
	protected function fontColor(){

		return imagecolorallocate($this->img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120));
	}


	//为背景画布填充颜色
	protected function filledColor(){

		imagefilledrectangle($this->img,0,0,$this->width,$this->height,$this->bgColor());
	}


	//画点噪声
	protected function pixed(){

		for($i=0;$i<50;$i++){

			imagesetpixel($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),$this->fontColor());
		}

	}


	//画圆弧噪声
	protected function arc(){

		for($i=0;$i<5;$i++){

			imagearc($this->img,mt_rand(10,$this->width-10),mt_rand(10,$this->height-10),40,35,mt_rand(0,180),mt_rand(180,360),$this->bgColor());
		}
	}

	//写字
	protected function write(){

		for($i=0;$i<$this->num;$i++){

			$x = ceil($this->width/$this->num)*$i;
			$y = mt_rand(0,$this->height-13);
			imagechar($this->img,5,$x,$y,$this->checkCode[$i],$this->fontColor());
		}

	}

	//输出
	protected function output(){
		$func = 'image'.$this->imgType;

		$header = 'Content-type:image/'.$this->imgType;
		if(function_exists($func)){

			header($header);
			$func($this->img);
		}else{

			echo '不支持的图片类型';
			exit;
		}
	}

	public function getImage(){

		$this->createImg();
		$this->filledColor();
		$this->pixed();
		$this->arc();
		$this->write();
		$this->output();
	}

	public function __get($proName){

		if($proName=='checkCode'){

			return $this->$proName;
		}
	}

	//销毁
	public function __destruct(){

		ImageDestroy($this->img);
	}
}
// END Verify CLASS

/* End of file Verify.php */
/* Location: ./shared/libraries/Verify.php */
